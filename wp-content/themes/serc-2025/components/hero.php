<?php
$bg_image = $args['bg_image'] ?? null;
$image = $args['image'] ?? null;
$title = $args['title'] ?? null;
$title_class = $args['title_class'] ?? "text-h2";
$subtitle = $args['subtitle'] ?? null;
$subtitle_class = $args['subtitle_class'] ?? "text-h4 mt-6";
$description = $args['description'] ?? null;
$description_class = $args['description_class'] ?? "flex items-center gap-2 mt-7";
$breadcrumbs = $args['breadcrumbs'] ?? null;
$center_y = $args['center_y'] ?? false;
$custom_html = $args['custom_html'] ?? null;

$class_names = [
	'hero' => true,
	'hero--inverted' => $bg_image,
	'hero--with-image' => $bg_image,
	'hero--center-y' => $center_y
];
$class_names = implode(' ', array_keys(array_filter($class_names)));
?>

<header class="<?php echo $class_names; ?>">
	<?php if ($bg_image) {
		echo $bg_image;
	} ?>
	<?php if ($breadcrumbs) : ?>
		<div class="container">
			<?php get_template_part('components/breadcrumbs', '', [
				'breadcrumbs' => $breadcrumbs
			]); ?>
		</div>
	<?php endif; ?>
	<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-center">
		<div class="lg:col-span-2 order-2 lg:order-1">
			<?php if ($title) : ?>
				<h1 class="<?php echo $title_class; ?>"><?php echo $title; ?></h1>
			<?php endif; ?>
			<?php if ($subtitle) : ?>
				<h2 class="<?php echo $subtitle_class; ?>"><?php echo $subtitle; ?></h2>
			<?php endif; ?>
			<?php if ($description) : ?>
				<div class="<?php echo $description_class; ?>">
					<?php echo $description; ?>
				</div>
			<?php endif; ?>
			<?php if ($custom_html) : ?>
				<?php echo $custom_html; ?>
			<?php endif; ?>
		</div>
		<?php if ($image) : ?>
			<div class="order-1 lg:order-2">
				<?php echo $image; ?>
			</div>
		<?php endif; ?>
	</div>
</header>