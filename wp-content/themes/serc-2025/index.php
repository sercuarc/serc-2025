<?php

/**
 * The main template file.
 */
?>

<?php get_header(); ?>

<main>
	<?php get_template_part('components/hero', null, [
		'title' => get_the_title(),
	]); ?>
	<section class="py-12 lg:py-20">
		<div class="container">
			<div class="wysiwyg">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>