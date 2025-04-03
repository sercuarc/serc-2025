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
		// Build sort param
		$sort = ['_score'];
		if (isset($params['sort'])) {
			$sortField = $params['sort'] . '.keyword';
			$sortOrder = isset($params['order']) ? $params['order'] : 'desc';
			$sort = [
				[$sortField => ['order' => $sortOrder]],
			];
		}
		// Buid page param
		$per_page = isset($params['per_page']) ? $params['per_page'] : 20;
		$page = isset($params['page']) ? intval($params['page']) : 1;
		$offset = ($page - 1) * $per_page;

		// Build query
		$query = [];

		// Build multi_match if a search term is provided
		if (isset($params['query'])) {
			$multi_match = [
				"query" => $params["query"],
				"fields" => ["title^2", "abstract", "description", "excerpt", "file", "file_text", "content"]
			];
		}

		// If doc_types are provided, build the filter
		if (isset($params['doc_types'])) {
			$doc_types = array_map('trim', explode(',', $params['doc_types']));
			$query["bool"] = [
				"filter" => [
					"terms" => ["type" => $doc_types]
				]
			];
			// If a search term is also provided, add it to the query
			if (isset($params['query'])) {
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
			"search_body" => $searchBody,
			"pages" => [
				"total" => ceil($docs['hits']['total']['value'] / $per_page),
				"current" => $page
			],
			"docs" => $docs,
		];
	}
}
