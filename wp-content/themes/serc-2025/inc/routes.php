<?php

/**
 * Theme Routes
 * 
 * Author: Kirk Pettinga (Studio Lekker)
 * Since: 0.1.0
 */

function serc_custom_routes()
{
	add_rewrite_rule('^search/?$', 'index.php?serc_search=1', 'top');
	add_rewrite_rule('^brand/?$', 'index.php?serc_brand=1', 'top');
	add_rewrite_rule(
		'^documents/publications/([0-9]+)/?$',
		'index.php?serc_document_type=publications&serc_document_id=$matches[1]',
		'top'
	);
	add_rewrite_rule(
		'^documents/technical-reports/([0-9]+)/?$',
		'index.php?serc_document_type=technical-reports&serc_document_id=$matches[1]',
		'top'
	);
}
add_action('init', 'serc_custom_routes');

function serc_validate_query_vars($query_vars)
{
	$query_vars[] = 'serc_search';
	$query_vars[] = 'query';
	$query_vars[] = 'serc_document_type';
	$query_vars[] = 'serc_document_id';
	$query_vars[] = 'serc_brand';
	return $query_vars;
}
add_filter('query_vars', 'serc_validate_query_vars');

function serc_load_custom_templates($template)
{
	if (get_query_var('serc_search') == 1) {
		return locate_template('serc-search.php');
	}
	if (get_query_var('serc_document_id')) {
		return locate_template('serc-document.php');
	}
	if (get_query_var('serc_brand')) {
		return locate_template('serc-brand.php');
	}
	return $template;
}
add_filter('template_include', 'serc_load_custom_templates');
