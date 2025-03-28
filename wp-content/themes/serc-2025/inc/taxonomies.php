<?php

/**
 * Custom Taxonomies
 */

add_action('init', 'register_member_roles');

function register_member_roles()
{
	$labels = [
		'name'              => _x('Member Roles', 'taxonomy general name'),
		'singular_name'     => _x('Member Role', 'taxonomy singular name'),
		'search_items'      => __('Search Member Roles'),
		'all_items'         => __('All Member Roles'),
		'parent_item'       => __('Parent Member Role'),
		'parent_item_colon' => __('Parent Member Role:'),
		'edit_item'         => __('Edit Member Role'),
		'update_item'       => __('Update Member Role'),
		'add_new_item'      => __('Add New Member Role'),
		'new_item_name'     => __('New Member Role Name'),
		'menu_name'         => __('Member Roles'),
	];

	$args = [
		'labels'            => $labels,
		'public'            => true,
		'hierarchical'      => true, // True = behaves like categories, False = behaves like tags
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'has_archive'       => false,
		'query_var'         => true,
		'rewrite'           => ['slug' => 'member-role'],
	];

	register_taxonomy('member_roles', ['people'], $args);
}
