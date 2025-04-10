<?php

/**
 * Open Search Controller
 */

namespace Serc2025;

define('INDEX_NAME', 'serc');

class OpenSearch
{
	private $client;

	public function __construct()
	{
		$this->client = (new \OpenSearch\GuzzleClientFactory())->create([
			'base_uri' => 'https://search-sercuarc-oa47557h4iqkm5pivmt4n3xc2y.us-east-2.es.amazonaws.com',
			'auth' => ['kirk', 'SERCSearch2025!'],
			'verify' => false, // Disables SSL verification for local development.
		]);
	}

	public function test()
	{
		return ['hello' => 'world'];
	}

	public function search($params)
	{
		$has_query 			= isset($params['query']) && $params['query'] != '';
		$is_exact 			= isset($params['exact']) && $params['exact'] === true;
		$has_sort 			= isset($params['sort']) && $params['sort'] != '_score';
		$has_order 			= isset($params['order']) && $params['order'] != '';
		$has_per_page 	= isset($params['per_page']) && $params['per_page'] != '';
		$has_page 			= isset($params['page']) && $params['page'] != '';
		$has_doc_types 	= isset($params['doc_types']) && $params['doc_types'] != '';
		$has_year 			= isset($params['year']) && $params['year'] != '' && $params['year'] != 'all';

		// Build sort param
		$sort = ['_score'];
		if ($has_sort) {
			$sortField = $params['sort'];
			$sortOrder = $has_order ? $params['order'] : 'desc';
			$sort = [
				[$sortField => ['order' => $sortOrder]],
			];
		}

		// Buid page param
		$per_page = $has_per_page ? $params['per_page'] : 20;
		$page = $has_page ? intval($params['page']) : 1;
		$offset = ($page - 1) * $per_page;

		// Build multi_match if a search term is provided
		if ($has_query) {
			$multi_match = [
				"query" => $params["query"],
				"type" => $is_exact ? "phrase" : "best_fields",
				"fields" => ["title^3", "abstract^2", "description^2", "excerpt^2", "content^2", "file", "file_text"]
			];
		}

		// Setup query
		$query = [];

		// If doc_types are provided, build the filter
		if ($has_doc_types || $has_year) {
			$filter = [];
			if ($has_doc_types) {
				$doc_types = $this->__parseDocTypes($params['doc_types']);
				$filter[] = ["terms" => ["type" => $doc_types]];
			}
			if ($has_year) {
				$filter[] = ["range" => [
					"unix_time" => [
						"gte" => strtotime($params['year'] . "-01-01T00:00:00-5:00"),
						"lte" => strtotime($params['year'] . "-12-31T23:59:59-5:00"),
					]
				]];
			}
			$query["bool"] = [
				"filter" => $filter
			];
			// If a search term is also provided, add it to the query
			if ($has_query) {
				$query["bool"]["must"] = [
					"multi_match" => $multi_match
				];
			}
		}
		// Otherwise, if it's a solo search query, just use the multi_match
		else if (isset($params['query'])) {
			$query["multi_match"] = $multi_match;
		}

		// Build search body
		$searchBody = [
			"size" => $per_page,
			"from" => $offset,
			"query" => $query,
			"sort" => $sort
		];
		// Execute search
		$docs = $this->client->search([
			"index" => INDEX_NAME,
			"body" => $searchBody
		]);
		// Return results
		return [
			"params" => $params,
			// "search_body" => $searchBody,
			"pages" => [
				"total" => ceil($docs['hits']['total']['value'] / $per_page),
				"current" => $page
			],
			"totalDocs" => $docs['hits']['total']['value'],
			"docs" => $this->__parseDocs($docs),
		];
	}

	private function __parseDocs($docs)
	{
		return array_map(function ($doc) {
			$source = $doc['_source'];
			$props = [
				"os_id" => $source['os_id'] ?? '',
				"title" => $source['title'] ?? '',
				"type" => $source['type'] ?? '',
			];
			// If Publication:
			if (isset($source['abstract'])) {
				$props['abstract'] = $this->__truncateText($source['abstract']);
				$props['authors'] = isset($source['authors']) ? array_map(function ($author) {
					$prefix = $author['prefix'] === 'Dr.' ? 'Dr. ' : '';
					$name = $author['first_name'] . ' ' . $author['last_name'];
					return $prefix . $name;
				}, $source['authors']) : [];
				$props["created_at"] = $source['created_at'] ?? '';
				$props["description"] = isset($source['description']) ? $this->__truncateText($source['description']) : '';
				$props["publication_date"] = $source['publication_date'] ?? '';
				$props["start_date"] = $source['start_date'] ?? '';
			}
			// If News/Post
			if ($source['type'] == 'News') {
				$props["content"] = $this->__truncateText($source['content']);
				$props["date_formatted"] = $source['date_formatted'] ?? '';
				$props["url"] = $source['url'] ?? '';
			}
			// If Event
			if ($source['type'] == 'Event') {
				$props["content"] = $this->__truncateText($source['content']);
				$props["date_formatted"] = $source['date_formatted'] ?? '';
				$props["url"] = $source['url'] ?? '';
				$props["venue_details"] = $source['venue_details'] ?? '';
			}
			// If People
			if ($source['type'] == 'People') {
				$props["content"] = $this->__truncateText($source['content']);
				$props["url"] = $source['url'] ?? '';
			}
			return $props;
		}, $docs['hits']['hits']);
	}

	private function __truncateText(string $text, int $words = 50)
	{
		$text = strip_tags($text);
		$textArray = explode(" ", $text);
		if (count($textArray) > $words) {
			return implode(" ", array_slice($textArray, 0, $words)) . '...';
		}
		return $text;
	}

	/**
	 * Get a list of document types from document type keywords
	 */
	private function __parseDocTypes($doc_types)
	{
		$doc_types = array_map('trim', explode(',', $doc_types));
		$parsed = [];
		foreach ($doc_types as $doc_type) {
			if ($doc_type == 'events-news') {
				$parsed[] = 'News';
				$parsed[] = 'Event';
			}
			if ($doc_type == 'media') {
				$parsed[] = 'Video';
				$parsed[] = 'Poster';
			}
			if ($doc_type == 'people') {
				$parsed[] = 'People';
			}
			if ($doc_type == 'other') {
				$parsed[] = "Other";
			}
			if ($doc_type == 'publications') {
				$parsed = array_merge($parsed, [
					"Annual Report",
					"Book",
					"Conference Paper",
					"Dissertation",
					"Executive Summary",
					"Good Reads",
					"Journal Article",
					"Poster",
					"Presentation",
					"Technical Report",
					"Video",
					"White Paper",
					"Workshop Report",
				]);
			}
		}
		return $parsed;
	}
}
