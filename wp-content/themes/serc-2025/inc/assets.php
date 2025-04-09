<?php

/**
 * Assets
 */
?>

<?php

define('THEME_URI', get_template_directory_uri());
define('DIST_URI', THEME_URI . '/assets/dist');
define('MANIFEST_PATH', get_template_directory() . '/dist/manifest.json');

function enqueue_asset_js($entry_point = "")
{
	if (file_exists(MANIFEST_PATH)) {
		$manifest = json_decode(file_get_contents(MANIFEST_PATH), true);

		// Get hashed JS file
		if (isset($manifest[$entry_point]['file'])) {
			$js_file = $manifest[$entry_point]['file'];
			wp_enqueue_script('serc-scripts', DIST_URI . '/js' . $js_file, [], null, true);
		}
	}
}

function enqueue_asset_css($entry_point = "")
{
	if (file_exists(MANIFEST_PATH)) {
		$manifest = json_decode(file_get_contents(MANIFEST_PATH), true);

		if (isset($manifest[$entry_point]['css'])) {
			foreach ($manifest[$entry_point]['css'] as $css_file) {
				wp_enqueue_style('serc-styles', DIST_URI . '/css' . $css_file, [], null);
			}
		}
	}
}

function enqueue_serc_scripts_styles()
{
	wp_enqueue_script('serc-scripts', DIST_URI . '/js/main.js', [], null, true);
	wp_enqueue_style('serc-styles', DIST_URI . '/css/main.css', [], null);
}
add_action('wp_enqueue_scripts', 'enqueue_serc_scripts_styles');
