<?php

function enqueue_serc_scripts_styles()
{
	$theme_uri = get_template_directory_uri();
	$dist_uri = $theme_uri . '/dist';
	$manifest_path = get_template_directory() . '/dist/manifest.json';

	// Read manifest.json to get the correct filenames
	if (file_exists($manifest_path)) {
		$manifest = json_decode(file_get_contents($manifest_path), true);
		$entry_point = 'wp-content/themes/serc-2025/src/js/main.js';

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
add_action('wp_enqueue_scripts', 'enqueue_serc_scripts_styles');
