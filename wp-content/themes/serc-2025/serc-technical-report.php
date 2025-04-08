<?php
$type = get_query_var('serc_document_type');
$id   = get_query_var('serc_document_id');

// Example remote fetch
// $response = wp_remote_get("https://web.sercuarc.org/api/{$type}/{$id}");
$response = wp_remote_get("https://web.sercuarc.org/api/publications/1");

if (!is_wp_error($response)) {
	$data = json_decode(wp_remote_retrieve_body($response), true);
}

// Now render your data
get_header(); ?>
<main>
	<h1 class="text-h1">Publication</h1>
	<pre><?php print_r($data); ?></pre>
</main>
<?php get_footer(); ?>