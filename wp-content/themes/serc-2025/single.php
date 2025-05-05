<?php

/**
 * Default Post
 */


get_header();
the_post();
$image = get_the_post_thumbnail($post, 'medium', ['class' => 'hero-image']);
$bg_image = get_field('background_image');
?>

<main>
	<?php get_template_part('components/hero', null, [
		'bg_image' => wp_get_attachment_image($bg_image, 'large', false, ['class' => 'hero-bg-image']),
		'blur_bg' => $image ? true : false,
		'right_column' => $image,
		'title' => get_the_title(),
		'description' => get_the_date('F j, Y'),
		'breadcrumbs' => [
			'News' => home_url('/news')
		]
	]); ?>
	<section class="py-12 lg:py-20">
		<div class="container grid grid-cols-1 lg:grid-cols-4 gap-9 lg:gap-18 items-start">
			<div class="lg:col-span-3 flex flex-col gap-10 lg:gap-20 order-2 lg:order-1">
				<div class="wysiwyg wysiwyg--lg">
					<?php the_content(); ?>
				</div>
			</div>
			<div class="lg:col-span-1 order-1 lg:order-2">
				<h3 class="text-h5">Share</h3>
				<?php get_template_part('components/share', null, [
					'title' => get_the_title(),
					'url' => get_the_permalink()
				]); ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>