<?php

/**
 * Template Helpers
 * A collection of helper functions for use in templates
 */

function serc_svg($id = "", $class_name = "icon")
{
	$sprite_path = get_template_directory_uri() . '/assets/icon-sprite.svg';
	return "<svg class='{$class_name}' fill='none'><use href='{$sprite_path}#{$id}'/></svg>";
}
