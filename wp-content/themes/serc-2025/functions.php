<?php

/**
 * Theme Functions
 * 
 * Author: Kirk Pettinga (Studio Lekker)
 * Since: 0.1.0
 */
?>

<?php
define('EMAIL_NEWSLETTER_ENDPOINT', 'https://app.e2ma.net/app2/audience/signup/1730920/1719796.1377361396/');

// !! Autoloaders must come first
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
require_once get_template_directory() . '/inc/autoloader.php';

// All the rest
require_once get_template_directory() . '/inc/admin.php';
require_once get_template_directory() . '/inc/api.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/blocks.php';
require_once get_template_directory() . '/inc/comments.php';
require_once get_template_directory() . '/inc/gravity-forms.php';
require_once get_template_directory() . '/inc/theme-config.php';
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/routes.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/template-helpers.php';
require_once get_template_directory() . '/inc/utilities.php';

function serc_enqueue_block_editor_styles()
{
	// Enqueue the editor stylesheet
	wp_enqueue_style(
		'serc-editor-styles', // Handle
		get_template_directory_uri() . '/editor-style.css', // Path to your editor-style.css
		array(), // Dependencies
		filemtime(get_template_directory() . '/editor-style.css') // Cache-busting
	);
}
add_action('enqueue_block_editor_assets', 'serc_enqueue_block_editor_styles');

// CLI Commands
require_once get_template_directory() . '/src/commands/ImportPeople.php';
