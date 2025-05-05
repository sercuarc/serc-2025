<?php
$bg_image = $args['bg_image'] ?? null;
$blur_bg = $args['blur_bg'] ?? false;
$right_column = $args['right_column'] ?? null;
$hide_right_column_on_mobile = $args['hide_right_column_on_mobile'] ?? false;
$title = $args['title'] ?? null;
$title_small = $args['title_small'] ?? null;
$subtitle = $args['subtitle'] ?? null;
$description = $args['description'] ?? null;
$description_class = $args['description_class'] ?? "flex items-center gap-2 mt-7";
$breadcrumbs = $args['breadcrumbs'] ?? null;
$center_y = $args['center_y'] ?? false;
$custom_html = $args['custom_html'] ?? null;

$class_names = [
	'hero' => true,
	'hero--inverted' => $bg_image,
	'hero--with-bg-image' => $bg_image,
	'hero--center-y' => $center_y,
	'hero--blur-bg' => $blur_bg
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
				<h1 class="hero-title"><?php echo $title; ?></h1>
			<?php endif; ?>
			<?php if ($title_small) : ?>
				<h1 class="hero-title-small"><?php echo $title_small; ?></h1>
			<?php endif; ?>
			<?php if ($subtitle) : ?>
				<h2 class="hero-subtitle"><?php echo $subtitle; ?></h2>
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
		<?php if ($right_column) : ?>
			<div class="order-1 lg:order-2 <?php echo $hide_right_column_on_mobile ? 'hidden lg:block' : '' ?>">
				<?php echo $right_column; ?>
			</div>
		<?php endif; ?>
	</div>
</header>