<?php

/**
 * Shortcodes
 */
function serc_button_shortcode($atts, $content = null)
{
	// Define default attributes
	$atts = shortcode_atts(
		array(
			'url' => '#', // Default URL
			'class' => 'btn-primary', // Default CSS class
			'target' => '_self', // Default target
			'rel' => 'noopener noreferrer', // Default rel attribute
		),
		$atts,
		'button'
	);

	// Return the button HTML
	return '<a href="' . esc_url($atts['url']) . '" target="' . esc_attr($atts['target']) . '" rel="' . esc_attr($atts['rel']) . '" class="btn ' . esc_attr($atts['class']) . '">' . esc_html($content) . '</a>';
}
add_shortcode('button', 'serc_button_shortcode');
