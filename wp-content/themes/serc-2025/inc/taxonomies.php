<?php

/**
 * Custom Taxonomies
 */

add_action('init', 'register_member_roles');
add_action('init', 'register_expertise');
add_action('init', 'register_organizations');

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

function register_organizations()
{
	$labels = [
		'name'              => _x('Organizations', 'taxonomy general name'),
		'singular_name'     => _x('Organization', 'taxonomy singular name'),
		'search_items'      => __('Search Organizations'),
		'all_items'         => __('All Organizations'),
		'parent_item'       => __('Parent Organization'),
		'parent_item_colon' => __('Parent Organization:'),
		'edit_item'         => __('Edit Organization'),
		'update_item'       => __('Update Organization'),
		'add_new_item'      => __('Add New Organization'),
		'new_item_name'     => __('New Organization Name'),
		'menu_name'         => __('Organizations'),
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
		'rewrite'           => ['slug' => 'organization'],
	];

	register_taxonomy('organizations', ['people'], $args);
}

function register_expertise()
{
	$labels = [
		'name'              => _x('Expertise', 'taxonomy general name'),
		'singular_name'     => _x('Expertise', 'taxonomy singular name'),
		'search_items'      => __('Search Expertise'),
		'all_items'         => __('All Expertise'),
		'parent_item'       => __('Parent Expertise'),
		'parent_item_colon' => __('Parent Expertise:'),
		'edit_item'         => __('Edit Expertise'),
		'update_item'       => __('Update Expertise'),
		'add_new_item'      => __('Add New Expertise'),
		'new_item_name'     => __('New Expertise Name'),
		'menu_name'         => __('Expertise'),
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
		'rewrite'           => ['slug' => 'expertise'],
	];

	register_taxonomy('expertise', ['people'], $args);
}
