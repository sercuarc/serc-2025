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

add_action('acf/init', function () {
	if (function_exists('acf_register_block_type')) {
		acf_register_block_type([
			'name'            => 'hero',
			'title'           => __('Hero'),
			'description'     => __('A hero container with a background image and text.'),
			'render_template' => 'blocks/hero.php',
			'category'        => 'serc-blocks',
			'icon'            => '<svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 96.998 96.998" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M94.998,18.667H2c-1.104,0-2,0.896-2,2v55.664c0,1.104,0.896,2,2,2h92.998c1.104,0,2-0.896,2-2V20.667 C96.998,19.562,96.104,18.667,94.998,18.667z M9.159,28.179c0-0.828,0.672-1.5,1.5-1.5h75.68c0.828,0,1.5,0.672,1.5,1.5v3.841 c0,0.828-0.672,1.5-1.5,1.5h-75.68c-0.828,0-1.5-0.672-1.5-1.5V28.179z M64.619,43.05v10.898c0,0.828-0.672,1.5-1.5,1.5h-29.24 c-0.828,0-1.5-0.672-1.5-1.5V43.05c0-0.828,0.672-1.5,1.5-1.5h29.24C63.947,41.55,64.619,42.222,64.619,43.05z M9.159,46.578 c0-0.828,0.672-1.5,1.5-1.5h15.92c0.828,0,1.5,0.672,1.5,1.5v3.842c0,0.828-0.672,1.5-1.5,1.5h-15.92c-0.828,0-1.5-0.672-1.5-1.5 V46.578z M87.839,68.819c0,0.828-0.672,1.5-1.5,1.5h-75.68c-0.828,0-1.5-0.672-1.5-1.5v-3.842c0-0.828,0.672-1.5,1.5-1.5h75.68 c0.828,0,1.5,0.672,1.5,1.5V68.819z M88.079,50.42c0,0.828-0.672,1.5-1.5,1.5h-15.92c-0.828,0-1.5-0.672-1.5-1.5v-3.842 c0-0.828,0.672-1.5,1.5-1.5h15.92c0.828,0,1.5,0.672,1.5,1.5V50.42z"></path> </g> </g></svg>',
			'mode'            => 'auto',
			'keywords'        => ['hero', 'image', 'background'],
		]);
		acf_register_block_type(array(
			'name'            => 'entity-list',
			'title'           => __('Entity List'),
			'description'     => __('A list of entities such as Organizations, Resources, etc.'),
			'render_template' => 'blocks/entity-list.php',
			'category'        => 'serc-blocks',
			'icon'            => 'excerpt-view',
			'mode'            => 'auto',
			'keywords'        => ['list', 'entity', 'entities', 'organizations', 'resources'],
		));
		acf_register_block_type(array(
			'name'            => 'grouped-list',
			'title'           => __('Grouped List'),
			'description'     => __('A list of items, grouped by headlines.'),
			'render_template' => 'blocks/grouped-list.php',
			'category'        => 'serc-blocks',
			'icon'            => 'list-view',
			'mode'            => 'auto',
			'keywords'        => ['list', 'group', 'organizations', 'resources'],
		));
	}
});
