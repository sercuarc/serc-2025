<?php

/**
 * Template Name: Contact
 */
?>

<?php get_header(); ?>

<?php $has_image = has_post_thumbnail() ?>

<main>
	<?php get_template_part('components/hero', null, [
		'bg_image' => get_the_post_thumbnail($post, 'large', ['class' => 'hero-bg-image']),
		'title' => get_the_title(),
		'center_y' => true
	]); ?>
	<section class="bg-white pt-12 lg:pt-16 pb-20 lg:pb-30">
		<div class="container">
			<div class="wysiwyg wysiwyg-lg">
				<?php the_content(); ?>
			</div>
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 mt:12 lg:mt-20">
				<div>
					<?php get_template_part("components/contact-form") ?>
				</div>
				<div>
					<p class="text-h5">Systems Engineering Research Center</p>
					<p class="text-light-surface-muted mt-2">Located at Stevens Institute of Technology</p>
					<address class="body-base mt-2">
						5 Marine View Plaza, Suite 501A
						<br>Hoboken, NJ 07030
					</address>
					<iframe class="w-full h-auto aspect-video lg:aspect-[3/4] mt-4" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3022.838966177997!2d-74.0295889!3d40.7435688!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259dc202aab67%3A0xf1be525024cc2fe1!2sSystems%20Engineering%20Research%20Center!5e0!3m2!1sen!2spa!4v1743111316950!5m2!1sen!2spa" width="600" height="800" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>