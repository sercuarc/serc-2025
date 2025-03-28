<?php

/**
 * Theme Functions
 * 
 * Author: Kirk Pettinga (Studio Lekker)
 * Since: 0.1.0
 */
?>

<?php

// !! Autoloaders must come first
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
require_once get_template_directory() . '/inc/autoloader.php';

// All the rest
require_once get_template_directory() . '/inc/admin.php';
require_once get_template_directory() . '/inc/api.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/comments.php';
require_once get_template_directory() . '/inc/theme-config.php';
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/routes.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/template-helpers.php';
require_once get_template_directory() . '/inc/utilities.php';
