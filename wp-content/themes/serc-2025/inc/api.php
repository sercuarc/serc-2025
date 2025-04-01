<?php

/**
 * SERC 2025 Default API
 */
?>

<?php

use Serc2025\Helpers;
use Serc2025\OpenSearch;

$serc_open_search = null;

add_action('rest_api_init', function () {
	global $serc_open_search;
	$serc_open_search = new OpenSearch(); // Initialize once
	$routes = [
		'/events' => 'serc_get_events',
		'/people' => 'serc_get_people',
		'/posts' => 'serc_get_posts',
		'/search' => 'serc_get_search',
	];
	foreach ($routes as $route => $callback) {
		register_rest_route('serc-2025/v1', $route, array(
			'methods' => 'GET',
			'callback' => $callback,
			'permission_callback' => '__return_true',
		));
	}
});

function serc_get_search(WP_REST_Request $request)
{
	global $serc_open_search;
	if (!$serc_open_search) {
		$serc_open_search = new OpenSearch(); // Fallback if not set
	}

	// $param1 = $request->get_param('param1'); // Get specific param
	// $all_params = $request->get_params(); // Get all params

	$results = $serc_open_search->search($request->get_params());
	return new WP_REST_Response($results, 200);
}

function serc_get_people(WP_REST_Request $request)
{
	$posts = array_map(function ($post) {
		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'id' => $post->ID,
			'type' => "People",
			'thumbnail' => get_the_post_thumbnail_url($post->ID),
			'name' => $post->post_title,
			'url' => get_permalink($post->ID),
			'title' => '[Professional Title]',
			'organization' => '[Organization]',
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'people']));

	return new WP_REST_Response($posts, 200);
}

function serc_get_posts(WP_REST_Request $request)
{
	$posts = array_map(function ($post) {
		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'date_formatted' => get_the_date('F j, Y', $post->ID),
			'date_unix' => get_the_date('U', $post->ID),
			'excerpt' => $post->post_excerpt,
			'id' => $post->ID,
			'type' => "News",
			'thumbnail' => get_the_post_thumbnail_url($post->ID),
			'title' => $post->post_title,
			'url' => get_permalink($post->ID),
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'post']));

	return new WP_REST_Response($posts, 200);
}

function serc_get_events(WP_REST_Request $request)
{
	$posts = array_map(function ($post) {

		// check if event is all day
		$isAllDay = get_post_meta($post->ID, '_EventAllDay', true);
		$start_date_unix = date('U', strtotime(get_post_meta($post->ID, '_EventStartDate', true)));
		$end_date_unix = date('U', strtotime(get_post_meta($post->ID, '_EventEndDate', true)));
		$date_formatted = Helpers::formatEventDates($start_date_unix, $end_date_unix, $isAllDay);
		$venue = tribe_get_venue($post->ID);

		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'date_formatted' => $date_formatted,
			'end_date_unix' => $end_date_unix,
			'excerpt' => $post->post_excerpt,
			'id' => $post->ID,
			'location' => ! $venue ? null : [
				'address' => tribe_get_address($post->ID),
				'city' => tribe_get_city($post->ID),
				'coordinates' => tribe_get_coordinates($post->ID),
				'country' => tribe_get_country($post->ID),
				'stateprovince' => tribe_get_stateprovince($post->ID),
				'zip' => tribe_get_zip($post->ID),
			],
			'type' => "Event",
			'start_date_unix' => $start_date_unix,
			'thumbnail' => get_the_post_thumbnail_url($post->ID),
			'title' => $post->post_title,
			'url' => get_permalink($post->ID),
			'venue' => $venue,
		];
	}, tribe_get_events(['posts_per_page' => -1, 'eventDisplay' => 'all']));

	return new WP_REST_Response($posts, 200);
}
