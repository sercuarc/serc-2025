<?php

/**
 * Assets
 */
?>

<?php

$get = wp_remote_get($_SERVER['DDEV_PRIMARY_URL'] . ':5173/@vite/client');
define('IS_DEV', wp_get_environment_type() === 'local' && $get["response"]["code"] == 200);
define('THEME_URI', get_template_directory_uri());
define('DIST_URI', THEME_URI . '/dist');
define('MANIFEST_PATH', get_template_directory() . '/dist/manifest.json');

function enqueue_asset_js($entry_point = "")
{
	if (file_exists(MANIFEST_PATH)) {
		$manifest = json_decode(file_get_contents(MANIFEST_PATH), true);

		// Get hashed JS file
		if (isset($manifest[$entry_point]['file'])) {
			$js_file = $manifest[$entry_point]['file'];
			wp_enqueue_script('serc-scripts', DIST_URI . '/' . $js_file, [], null, true);
		}
	}
}

function enqueue_asset_css($entry_point = "")
{
	if (file_exists(MANIFEST_PATH)) {
		$manifest = json_decode(file_get_contents(MANIFEST_PATH), true);

		if (isset($manifest[$entry_point]['css'])) {
			foreach ($manifest[$entry_point]['css'] as $css_file) {
				wp_enqueue_style('serc-styles', DIST_URI . '/' . $css_file, [], null);
			}
		}
	}
}

function enqueue_serc_scripts_styles()
{
	if (IS_DEV) {
		echo '<script type="module" src="' . preg_replace('/:\d+$/', '', $_SERVER['DDEV_PRIMARY_URL']) . ':5173/@vite/client"></script>';
		echo '<script type="module" src="' . preg_replace('/:\d+$/', '', $_SERVER['DDEV_PRIMARY_URL']) . ':5173/vite/js/main.js"></script>';
	} else {
		enqueue_asset_js("vite/js/main.js");
		enqueue_asset_css("vite/js/main.js");
	}
}
add_action('wp_enqueue_scripts', 'enqueue_serc_scripts_styles');
