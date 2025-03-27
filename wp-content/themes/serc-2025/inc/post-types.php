<?php

/**
 * SERC 2025 Post Types
 */

// Rename the default "post" post type to "news"
add_filter('register_post_type_args', function ($args, $post_type) {
	if ('post' === $post_type) {
		$args['labels']['name'] = __('News');
		$args['labels']['singular_name'] = __('News');
		$args['labels']['menu_name'] = __('News');
	}
	return $args;
}, 10, 2);

// register a "people" post type
add_action('init', function () {
	register_post_type('people', [
		'label' => 'People',
		'public' => true,
		'has_archive' => true,
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-groups',
		'singular_name' => 'Person',
	]);
});
