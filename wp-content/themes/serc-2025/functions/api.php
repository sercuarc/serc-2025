<?php

/**
 * SERC 2025 Default API
 */
?>

<?php

function serc_get_posts()
{
	$posts = array_map(function ($post) {
		return [
			'author' => get_the_author_meta('display_name', $post->post_author),
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'date' => get_the_date('Y-m-d', $post->ID),
			'excerpt' => $post->post_excerpt,
			'id' => 'wp-' . $post->post_type . '-' . $post->ID,
			'post_type' => $post->post_type,
			'title' => $post->post_title,
			'url' => get_permalink($post->ID),
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'post']));

	return new WP_REST_Response($posts, 200);
}

function serc_get_events()
{
	$posts = array_map(function ($post) {

		$start_date = get_post_meta($post->ID, '_EventStartDate', true);
		$end_date = get_post_meta($post->ID, '_EventEndDate', true);

		return [
			'content' => str_replace(["\n", "\r"], '', strip_tags($post->post_content)),
			'date' => get_the_date('Y-m-d', $post->ID),
			'start_date' => date('Y-m-d H:i', strtotime($start_date)),
			'end_date' => date('Y-m-d H:i', strtotime($end_date)),
			'excerpt' => $post->post_excerpt,
			'id' => 'wp-' . $post->post_type . '-' . $post->ID,
			'post_type' => $post->post_type,
			'title' => $post->post_title,
			'url' => get_permalink($post->ID),
			'venue' => tribe_get_venue($post->ID),
		];
	}, get_posts(['numberposts' => -1, 'post_type' => 'tribe_events']));

	return new WP_REST_Response($posts, 200);
}

add_action('rest_api_init', function () {
	$routes = [
		'/posts' => 'serc_get_posts',
		'/events' => 'serc_get_events',
	];
	foreach ($routes as $route => $callback) {
		register_rest_route('serc-2025/v1', $route, array(
			'methods' => 'GET',
			'callback' => $callback,
		));
	}
});
