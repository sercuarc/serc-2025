<?php
$title = get_field('hero_title');
$subtitle = get_field('hero_subtitle');
$image = get_field('hero_image');
$button = get_field('hero_button');
$button_html = '';

if ($button) :
	ob_start(); ?>
	<a href="<?php echo $button['url']; ?>" class="btn btn-primary btn-lg" target="<?php echo $button['target']; ?>" rel="noopener noreferrer"><?php echo $button['title']; ?></a>
<?php endif;
$button_html = ob_get_clean();

get_template_part('components/hero', null, [
	'image' => wp_get_attachment_image($image, 'small', false, [
		'class' => 'hero-image'
	]),
	'bg_image' => wp_get_attachment_image(get_field('hero_bg_image'), 'large', false, [
		'class' => 'hero-bg-image'
	]),
	'blur_bg' => $image ? true : false,
	'title' => $title,
	'title_class' => 'text-h1',
	'subtitle' => $subtitle,
	'description' => $button_html,
	'description_class' => 'mt-7 text-lg lg:text-xl',
	'center_y' => true
]);
