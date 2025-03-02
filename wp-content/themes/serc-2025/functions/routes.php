<?php

/**
 * Theme Routes
 * 
 * Author: Kirk Pettinga (Studio Lekker)
 * Since: 1.0
 */

function serc_custom_routes()
{
	add_rewrite_rule('^search/?$', 'index.php?serc_search=1', 'top');
}
add_action('init', 'serc_custom_routes');

function serc_validate_query_vars($query_vars)
{
	$query_vars[] = 'serc_search';
	$query_vars[] = 'query';
	return $query_vars;
}
add_filter('query_vars', 'serc_validate_query_vars');

function serc_load_custom_templates($template)
{
	if (get_query_var('serc_search') == 1) {
		return locate_template('serc-search.php');
	}
	return $template;
}
add_filter('template_include', 'serc_load_custom_templates');
