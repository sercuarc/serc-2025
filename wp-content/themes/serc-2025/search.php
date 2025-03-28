<?php

/**
 * Default Search
 * Description: Default Wordpress search. Reroutes to custom search.
 * See {theme}/serc-search.php
 */
?>

<?php wp_redirect('/search?query=' . get_search_query(), 301, '') ?>