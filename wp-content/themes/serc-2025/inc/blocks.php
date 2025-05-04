<?php

/**
 * Add SERC Blocks Category
 */
add_filter('block_categories_all', function ($categories, $post) {
	// Your custom category
	$custom_category = [
		'slug'  => 'serc-blocks',
		'title' => __('SERC Blocks', 'serc'),
		'icon'  => null,
	];

	return [$custom_category];
}, 10, 2);

/**
 * Allow ONLY SERC Blocks
 */
add_filter('allowed_block_types_all', function ($allowed_blocks, $editor_context) {
	$all_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
	$allowed = [];

	foreach ($all_blocks as $block_name => $block_obj) {
		if (str_starts_with($block_name, 'acf/') || str_starts_with($block_name, 'serc/')) {
			$allowed[] = $block_name;
		}
	}
	return $allowed;
}, 10, 2);

/**
 * Register ACF Blocks
 */
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
			'name'            => 'wysiwyg',
			'title'           => __('WYSIWYG'),
			'description'     => __('A Rich Text Editor block.'),
			'render_template' => 'blocks/wysiwyg.php',
			'category'        => 'serc-blocks',
			'icon'            => 'text',
			'mode'            => 'auto',
			'keywords'        => ['text', 'wysiwyg', 'editor', 'rich text'],
		));
		acf_register_block_type(array(
			'name'            => 'text-image',
			'title'           => __('Text & Image(s)'),
			'description'     => __('Text and image pairing. Multiple images can be added.'),
			'render_template' => 'blocks/text-image.php',
			'category'        => 'serc-blocks',
			'icon'            => '<svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" fill="none"><rect x="0" y="1" width="6" height="5" fill="black" /><rect x="8" y="1" width="6" height="1" fill="black" /><rect x="8" y="3" width="6" height="1" fill="black" /><rect x="8" y="5" width="6" height="1" fill="black" /><rect x="8" y="8" width="6" height="5" fill="black" /><rect x="0" y="8" width="6" height="1" fill="black" /><rect x="0" y="10" width="6" height="1" fill="black" /><rect x="0" y="12" width="6" height="1" fill="black" /></svg>',
			'mode'            => 'auto',
			'keywords'        => ['image', 'tiles', 'gallery', 'text', 'wysiwyg'],
		));
		acf_register_block_type(array(
			'name'            => 'text-image-slider',
			'title'           => __('Text w/ Image Slider'),
			'description'     => __('Text with an adjacent image slider.'),
			'render_template' => 'blocks/text-image-slider.php',
			'category'        => 'serc-blocks',
			'icon'            => '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"><g transform="translate(0, 4)"><rect x="0" y="1" width="9" height="9" fill="black" /><rect x="11" y="1" width="9" height="3" fill="black" /><rect x="11" y="5" width="9" height="1" fill="black" /><rect x="11" y="7" width="9" height="1" fill="black" /><rect x="11" y="9" width="6" height="1" fill="black" /><rect x="2" y="11" width="1" height="1" fill="black" /><rect x="4" y="11" width="1" height="1" fill="black" /><rect x="6" y="11" width="1" height="1" fill="black" /></g></svg>',
			'mode'            => 'auto',
			'keywords'        => ['image', 'text', 'wysiwyg', 'slider', 'gallery'],
		));
		acf_register_block_type(array(
			'name'            => 'image-tiles',
			'title'           => __('Image Tiles'),
			'description'     => __('A collection of image tiles with text.'),
			'render_template' => 'blocks/image-tiles.php',
			'category'        => 'serc-blocks',
			'icon'            => 'screenoptions',
			'mode'            => 'auto',
			'keywords'        => ['image', 'tiles', 'gallery'],
		));
		acf_register_block_type(array(
			'name'            => 'banner',
			'title'           => __('Banner'),
			'description'     => __('A banner with a title, description, and button.'),
			'render_template' => 'blocks/banner.php',
			'category'        => 'serc-blocks',
			'icon'            => 'align-wide',
			'mode'            => 'auto',
			'keywords'        => ['text', 'banner', 'button'],
		));
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
		acf_register_block_type(array(
			'name'            => 'news',
			'title'           => __('News'),
			'description'     => __('A grid of news posts.'),
			'render_template' => 'blocks/news.php',
			'category'        => 'serc-blocks',
			'icon'            => '<svg fill="#000000" height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M0,149.854v212.293h512V149.854H0z M158.179,324.683H37.463V187.317h120.716V324.683z M316.357,324.683H195.643V187.317 h120.715V324.683z M474.537,324.683H353.821V187.317h120.716V324.683z"></path> </g> </g> </g></svg>',
			'mode'            => 'auto',
			'keywords'        => ['news', 'group', 'articles', 'posts'],
		));
	}
});
