<?php

/**
 * SERC 2025 Search API
 */
?>

<?php

use MeiliSearch\Client;

class SercMeiliSearch
{
	private $client;

	public function __construct()
	{
		// $this->client = new Client("https://ms-71a3b6a3bbb8-19578.nyc.meilisearch.io", "e039af59a91f61839b529952ab37c588b1fc63eb");
		$this->client = new Client($_ENV['MEILISEARCH_HOST'], $_ENV['MEILISEARCH_KEY']);
	}

	public function getSearch()
	{
		$query = isset($_GET['query']) ? $_GET['query'] : "";
		$sort = isset($_GET['sort']) ? $_GET['sort'] : "";
		$searchParams = array();
		switch ($sort) {
			case 'date':
				$searchParams['sort'] = ['publication_date:desc'];
				break;
			case 'title':
				$searchParams['sort'] = ['title:asc'];
				break;
			default:
				break;
		}
		$search = $this->client->index('technical-reports')->search($query, $searchParams);
		$results = $search->getRaw();

		// sanitize results
		foreach ($results['hits'] as $key => $result) {
			$results['hits'][$key]['abstract'] = strip_tags($result['abstract'] ?? "");
		}

		return new WP_REST_Response($results, 200);
	}
}

add_action('rest_api_init', function () {
	$meiliSearch = new SercMeiliSearch();
	register_rest_route('serc-2025/v1', '/search', array(
		'methods' => 'GET',
		'callback' => [$meiliSearch, 'getSearch'],
	));
});
