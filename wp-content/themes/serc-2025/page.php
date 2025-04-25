<?php

/**
 * Default Page
 */
?>

<?php get_header(); ?>

<main>
	<?php get_template_part('components/hero', null, [
		'bg_image' => get_the_post_thumbnail($post, 'large', ['class' => 'hero-bg-image']),
		'title' => get_the_title(),
		'center_y' => true
	]); ?>
	<section class="bg-white pt-12 lg:pt-16 pb-20 lg:pb-30">
		<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16">
			<div class="lg:col-span-2 wysiwyg wysiwyg-lg">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>