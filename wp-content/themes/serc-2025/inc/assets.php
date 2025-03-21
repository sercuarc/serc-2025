<?php

/**
 * Assets
 */

function enqueue_serc_scripts_styles()
{
	// $is_dev = strpos($_SERVER['HTTP_HOST'], 'ddev.site') !== false;
	$get = wp_remote_get($_SERVER['DDEV_PRIMARY_URL'] . ':5173/@vite/client');
	$is_dev = wp_get_environment_type() === 'local' && $get["response"]["code"] == 200;

	if ($is_dev) {
		echo '<script type="module" src="' . preg_replace('/:\d+$/', '', $_SERVER['DDEV_PRIMARY_URL']) . ':5173/@vite/client"></script>';
		echo '<script type="module" src="' . preg_replace('/:\d+$/', '', $_SERVER['DDEV_PRIMARY_URL']) . ':5173/vite/js/main.js"></script>';
	} else {
		$theme_uri = get_template_directory_uri();
		$dist_uri = $theme_uri . '/dist';
		$manifest_path = get_template_directory() . '/dist/manifest.json';

		// Read manifest.json to get the correct filenames
		if (file_exists($manifest_path)) {
			$manifest = json_decode(file_get_contents($manifest_path), true);
			$entry_point = 'js/main.js';

			// Get hashed JS file
			if (isset($manifest[$entry_point]['file'])) {
				$js_file = $manifest[$entry_point]['file'];
				wp_enqueue_script('serc-scripts', $dist_uri . '/' . $js_file, [], null, true);
			}

			// Get hashed CSS file
			if (isset($manifest[$entry_point]['css'])) {
				foreach ($manifest[$entry_point]['css'] as $css_file) {
					wp_enqueue_style('serc-styles', $dist_uri . '/' . $css_file, [], null);
				}
			}
		}
	}
}
add_action('wp_enqueue_scripts', 'enqueue_serc_scripts_styles');
