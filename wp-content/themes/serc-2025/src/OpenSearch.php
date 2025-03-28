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
		$docs = $this->client->search([
			'index' => INDEX_NAME,
			'body' => [
				'size' => 5,
				'query' => [
					'multi_match' => [
						'query' => 'miller',
						'fields' => ['title^2', 'director']
					]
				]
			]
		]);
		return [
			'docs' => $docs,
			'params' => $params
		];
	}
}
