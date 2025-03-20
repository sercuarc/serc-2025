<?php

/**
 * Menus
 */

function serc_register_menus()
{
	register_nav_menus([
		// 'primary_menu' => __('Primary', 'serc'),
		// 'footer_menu'  => __('Footer', 'serc'),
	]);
}
add_action('after_setup_theme', 'serc_register_menus');
