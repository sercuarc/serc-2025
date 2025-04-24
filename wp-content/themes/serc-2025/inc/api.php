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
		'/events' => ['method' => 'GET', 'callback' => 'serc_get_events'],
		'/people' => ['method' => 'GET', 'callback' => 'serc_get_people'],
		'/posts' => ['method' => 'GET', 'callback' => 'serc_get_posts'],
		'/search' => ['method' => 'POST', 'callback' => 'serc_get_search'],
	];
	foreach ($routes as $route => $props) {
		register_rest_route('serc-2025/v1', $route, array(
			'methods' => $props['method'],
			'callback' => $props['callback'],
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

	$all_params = $request->get_params(); // Get all params

	$results = $serc_open_search->search($all_params);
	return new WP_REST_Response($results, 200);
}

function serc_get_people(WP_REST_Request $request)
{
	$posts = array_map(function ($post) {
		$thumbnail = get_the_post_thumbnail_url($post->ID);
		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'created_at' => get_the_date('F j, Y', $post->ID),
			'id' => $post->ID,
			'title' => $post->post_title,
			'organization' => '[Organization]',
			'thumbnail' => $thumbnail ? $thumbnail : '',
			'professional_title' => '[Professional Title]',
			'type' => "People",
			'url' => get_permalink($post->ID),
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'people']));

	return new WP_REST_Response($posts, 200);
}

function serc_get_posts(WP_REST_Request $request)
{
	$posts = array_map(function ($post) {
		$thumbnail = get_the_post_thumbnail_url($post->ID);
		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'date_formatted' => get_the_date('F j, Y', $post->ID),
			'excerpt' => $post->post_excerpt,
			'id' => $post->ID,
			'thumbnail' => $thumbnail ? $thumbnail : '',
			'title' => $post->post_title,
			'type' => "News",
			'url' => get_permalink($post->ID),
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'post']));

	return new WP_REST_Response($posts, 200);
}

function serc_get_events(WP_REST_Request $request)
{
	$posts = array_map(function ($post) {

		$isAllDay = get_post_meta($post->ID, '_EventAllDay', true);
		$start_date = get_post_meta($post->ID, '_EventStartDate', true);
		$end_date = get_post_meta($post->ID, '_EventEndDate', true);
		$date_formatted = Helpers::format_event_dates($start_date, $end_date, $isAllDay);
		$venue = tribe_get_venue($post->ID);
		$thumbnail = get_the_post_thumbnail_url($post->ID);

		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'date_formatted' => $date_formatted,
			'end_date' => date('F j, Y', strtotime($end_date)),
			'excerpt' => $post->post_excerpt,
			'id' => $post->ID,
			'venue_details' => [
				'address' => tribe_get_address($post->ID),
				'city' => tribe_get_city($post->ID),
				'coordinates' => tribe_get_coordinates($post->ID),
				'country' => tribe_get_country($post->ID),
				'stateprovince' => tribe_get_stateprovince($post->ID),
				'zip' => tribe_get_zip($post->ID),
			],
			'start_date' => date('F j, Y', strtotime($start_date)),
			'thumbnail' => $thumbnail ? $thumbnail : '',
			'title' => $post->post_title,
			'type' => "Event",
			'url' => get_permalink($post->ID),
			'venue' => $venue ? $venue : "",
		];
	}, tribe_get_events(['posts_per_page' => -1, 'eventDisplay' => 'all']));

	return new WP_REST_Response($posts, 200);
}
