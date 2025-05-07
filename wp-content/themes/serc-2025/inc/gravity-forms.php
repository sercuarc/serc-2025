<?php

/**
 * Gravity Forms
 *
 * @package SERC
 */

// Disable CSS
add_filter('gform_disable_css', '__return_true');

// Customize CSS Classes
add_filter('gform_field_css_class', function ($classes, $field, $form) {
	// Append a class to every field
	$classes .= ' field';

	// Example: Add class only to text fields
	if ($field->type === 'select') {
		$classes .= ' field-select';
	}
	if ($field->type === 'name' || $field->type === 'email' || $field->type === 'text' || $field->type === 'textarea') {
		$classes .= ' field-text';
	}
	if ($field->type === 'checkbox') {
		$classes .= ' field-checkbox';
	}
	if ($field->type === 'radio') {
		$classes .= ' field-radio';
	}

	return $classes;
}, 10, 3);

// Customize field markup
add_filter('gform_field_content', function ($content, $field, $value, $lead_id, $form_id) {

	// Add class to labels
	$content = str_replace(
		'gfield_label gform-field-label',
		'gfield_label gform-field-label label',
		$content
	);

	// Add class to sub-labels
	$content = str_replace(
		'gform-field-label gform-field-label--type-sub',
		'gform-field-label gform-field-label--type-sub hint',
		$content
	);

	return $content;
}, 10, 5);

// Customize Submit
add_filter('gform_submit_button', function ($button, $form) {
	return "<button class='gform_button btn btn-primary' id='gform_submit_button_{$form['id']}'>{$form['button']['text']}</button>";
}, 10, 2);
