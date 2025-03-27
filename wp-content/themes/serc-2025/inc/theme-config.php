<?php

/**
 * Theme Customizations
 */

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
