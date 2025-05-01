<?php
$image = get_field('hero_image');
get_template_part('components/hero', null, [
	'image' => wp_get_attachment_image($image, 'small', false, [
		'class' => 'hero-image'
	]),
	'bg_image' => wp_get_attachment_image(get_field('hero_bg_image'), 'large', false, [
		'class' => 'hero-bg-image'
	]),
	'blur_bg' => $image ? true : false,
	'title' => get_field('hero_title'),
	'title_class' => 'text-h1',
	'subtitle' => get_field('hero_subtitle'),
	'description' => apply_filters('the_content', get_field('hero_description')),
	'description_class' => 'mt-7 text-lg lg:text-xl',
	'center_y' => true
]);
