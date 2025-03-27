<?php

/**
 * Default Post
 */
?>

<?php get_header(); ?>

<?php $image = get_the_post_thumbnail($post, 'full'); ?>

<main>
	<header class="hero <?php if ($image) : ?>hero--inverted hero--with-image<?php endif; ?>">
		<?php if ($image = null) : ?>
			<?php echo $image; ?>
		<?php endif; ?>
		<div class="container">
			<h1 class="text-h1"><?php the_title(); ?></h1>
		</div>
	</header>
	<section class="bg-white pt-12 lg:pt-16 pb-20 lg:pb-30">
		<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16">
			<div class="lg:col-span-2 wysiwyg wysiwyg-lg">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>