<?php

/**
 * Block Customizations
 */


add_filter('block_categories_all', function ($categories, $post) {
	// Your custom category
	$custom_category = [
		'slug'  => 'serc-blocks',
		'title' => __('SERC Blocks', 'serc'),
		'icon'  => null,
	];

	// Remove it if it already exists (avoid duplicates)
	$categories = array_filter($categories, function ($cat) {
		return $cat['slug'] !== 'serc-blocks';
	});

	// Prepend to the beginning
	array_unshift($categories, $custom_category);

	return $categories;
}, 10, 2);

// add_action('acf/init', function () {
// 	if (function_exists('acf_register_block_type')) {
// 		acf_register_block_type(array(
// 			'name'            => 'people',
// 			'title'           => __('People'),
// 			'description'     => __('A list of people with their name, image, and title.'),
// 			'render_template' => 'blocks/people.php',
// 			'category'        => 'serc-blocks',
// 			'icon'            => 'groups',
// 			'mode'            => 'auto',
// 			'keywords'        => array('people'),
// 		));
// 		acf_register_block_type(array(
// 			'name'            => 'tabs',
// 			'title'           => __('Tabs'),
// 			'description'     => __('A set of tabbed containers.'),
// 			'render_template' => 'blocks/tabs.php',
// 			'category'        => 'serc-blocks',
// 			'icon'            => 'category',
// 			'mode'            => 'auto',
// 			'keywords'        => array('tabs'),
// 		));
// 	}
// });
