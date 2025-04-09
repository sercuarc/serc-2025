<?php

/**
 * Utility functions
 */

function get_formatted_name(WP_Post|int $post)
{
	if (is_numeric($post)) {
		$post = get_post($post);
	}
	$name = trim(implode(' ', array_filter([
		get_field('prefix', $post) === 'Dr.' ? 'Dr.' : '',
		$post->post_title ?? '',
		get_field('suffix', $post) ?? ''
	])));

	return $name;
}
