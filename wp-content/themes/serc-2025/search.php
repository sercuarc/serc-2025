<?php

/**
 * Template Name: Search
 * Description: Default Wordpress search. Reroutes to custom search.
 */
?>

<?php wp_redirect('/search?query=' . get_search_query(), 301, '') ?>