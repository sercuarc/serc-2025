<?php

/**
 * Utility functions
 */

function get_people($role)
{
	if ($role === 'staff') {
		$response = wp_remote_get('https://web.sercuarc.org/api/people?roles=SERC+Staff');
	} else {
		$response = wp_remote_get('https://web.sercuarc.org/api/people');
	}
	if (is_wp_error($response)) {
		return null;
	}
	return json_decode(wp_remote_retrieve_body($response));
}
