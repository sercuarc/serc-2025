<?php

/**
 * Theme Customizations
 */

function serc_dynamic_home_url($url)
{
	if (!empty($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'ngrok')) {
		return preg_replace('#^https://serc\.ddev\.site#', 'https://' . $_SERVER['HTTP_HOST'], $url);
	}
	return $url;
}
add_filter('home_url', 'serc_dynamic_home_url');
add_filter('site_url', 'serc_dynamic_home_url');
add_filter('template_directory_uri', 'serc_dynamic_home_url');
add_filter('stylesheet_directory_uri', 'serc_dynamic_home_url');


/**
 * Modifies the WordPress login page to display the SERC logo.
 *
 * Specifically, this function adds a <style> block to the login page
 * that sets the background image of the "WordPress" logo to the SERC
 * logo, and sets the size of the logo to 270x190px.
 */
function custom_login_logo()
{
	echo '<style type="text/css">
			.login h1 a {
					background-image: url(' . get_bloginfo('template_directory') . '/images/logo-vert-color.svg);
					background-size: cover;
					width: 270px;
					height: 190px;
			}
	</style>';
}
add_action('login_head', 'custom_login_logo');

/**
 * Customize the sections in the WordPress Customizer.
 *
 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager instance.
 */
function serc_set_customizer_sections($wp_customize)
{
	$wp_customize->remove_section('static_front_page');
	$wp_customize->remove_section('custom_css');
}
add_action('customize_register', 'serc_set_customizer_sections', 15);

/**
 * Adds theme support for various WordPress features.
 */
function serc_theme_support()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails', ['people', 'page', 'post', 'tribe_events']);
}
add_action('after_setup_theme', 'serc_theme_support');

/**
 * Adds a custom editor style to the admin dashboard.
 */
add_action('admin_init', function () {
	add_editor_style('editor-style.css');
});

/**
 * Adds a custom class to the TinyMCE editor for the admin dashboard.
 */
add_filter('tiny_mce_before_init', function ($init) {
	$init['body_class'] = 'wysiwyg'; // Add your custom class here
	return $init;
});
