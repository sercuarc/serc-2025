<?php

/**
 * SERC 2025 Post Types
 */

/**
 * Post Type: Post
 * -----------------------------------------------------------------------------------
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


/**
 * Post Type: People
 * -----------------------------------------------------------------------------------
 */
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

// Modify Permalinks for "People" Posts

add_filter('post_type_link', function ($permalink, $post, $leavename) {
	if ($post->post_type === 'people') {
		$external_url = get_field('external_bio_url', $post->ID);
		if (!empty($external_url)) {
			return $external_url;
		}
	}
	return $permalink;
}, 10, 3);

// Prevent Access to the Local Permalink

add_action('template_redirect', function () {
	if (is_singular('people')) {
		$external_url = get_field('external_bio_url');
		if (!empty($external_url)) {
			wp_redirect($external_url, 301);
			exit;
		}
	}
});
