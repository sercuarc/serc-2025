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
		'has_archive' => false,
		'supports' => ['title', 'editor', 'thumbnail'],
		'taxonomies' => ['member_roles'],
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-groups',
		'singular_name' => 'Person',
	]);
});

// Disable the block editor for the "people" post type
add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
	if ($post_type === 'people') {
		return false;
	}
	return $use_block_editor;
}, 10, 2);
