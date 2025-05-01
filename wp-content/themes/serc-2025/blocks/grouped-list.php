<?php get_template_part('components/grouped-list', null, [
	'title' => get_field('grouped_list_title') ?: 'Grouped List Title',
	'subtitle' => get_field('grouped_list_subtitle') ?: 'Grouped List Subtitle',
	'groups' => get_field('grouped_list_groups'),
]);
