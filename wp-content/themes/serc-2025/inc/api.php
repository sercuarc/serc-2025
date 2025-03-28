<?php

/**
 * SERC 2025 Default API
 */
?>

<?php

use Serc2025\Helpers;

function serc_get_people()
{
	$posts = array_map(function ($post) {
		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'id' => 'wp-' . $post->post_type . '-' . $post->ID,
			'post_type' => $post->post_type,
			'thumbnail' => get_the_post_thumbnail_url($post->ID),
			'name' => $post->post_title,
			'url' => get_permalink($post->ID),
			'title' => '[Professional Title]',
			'organization' => '[Organization]',
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'people']));

	return new WP_REST_Response($posts, 200);
}

function serc_get_posts()
{
	$posts = array_map(function ($post) {
		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'date_formatted' => get_the_date('F j, Y', $post->ID),
			'date_unix' => get_the_date('U', $post->ID),
			'excerpt' => $post->post_excerpt,
			'id' => 'wp-' . $post->post_type . '-' . $post->ID,
			'post_type' => $post->post_type,
			'thumbnail' => get_the_post_thumbnail_url($post->ID),
			'title' => $post->post_title,
			'url' => get_permalink($post->ID),
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'post']));

	return new WP_REST_Response($posts, 200);
}

function serc_get_events()
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
			'id' => 'wp-' . $post->post_type . '-' . $post->ID,
			'location' => ! $venue ? null : [
				'address' => tribe_get_address($post->ID),
				'city' => tribe_get_city($post->ID),
				'coordinates' => tribe_get_coordinates($post->ID),
				'country' => tribe_get_country($post->ID),
				'stateprovince' => tribe_get_stateprovince($post->ID),
				'zip' => tribe_get_zip($post->ID),
			],
			'post_type' => $post->post_type,
			'start_date_unix' => $start_date_unix,
			'thumbnail' => get_the_post_thumbnail_url($post->ID),
			'title' => $post->post_title,
			'url' => get_permalink($post->ID),
			'venue' => $venue,
		];
	}, tribe_get_events(['posts_per_page' => -1, 'eventDisplay' => 'all']));

	return new WP_REST_Response($posts, 200);
}

add_action('rest_api_init', function () {
	$routes = [
		'/posts' => 'serc_get_posts',
		'/events' => 'serc_get_events',
		'/people' => 'serc_get_people',
	];
	foreach ($routes as $route => $callback) {
		register_rest_route('serc-2025/v1', $route, array(
			'methods' => 'GET',
			'callback' => $callback,
			'permission_callback' => '__return_true',
		));
	}
});
