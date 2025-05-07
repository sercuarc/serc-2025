<?php
if (! function_exists('gravity_form')) {
	echo '<p>Gravity Forms plugin is not activated.</p>';
	return;
}

$id = $args['id'] ?? '';

if (! $id) {
	echo '<p>Gravity Form ID is missing</p>';
	return;
}

$display_title = false;
$display_description = false;
$display_inactive = false;
$field_values = null;
$ajax = true;

gravity_form($id, $display_title, $display_description, $display_inactive, $field_values, $ajax);
