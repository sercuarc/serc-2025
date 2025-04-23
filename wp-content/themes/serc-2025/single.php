<?php

/**
 * Default Post
 */


get_header();
the_post();

$image = get_the_post_thumbnail($post, 'full', array('class' => 'blur-sm'));

$breadcrumbs = [
	'News' => home_url('/news')
];

?>

<main>
	<header class="hero <?php if ($image) : ?>hero--inverted hero--with-image<?php endif; ?>">
		<?php
		if ($image) {
			echo $image;
		}
		?>
		<div class="container">
			<?php get_template_part('components/breadcrumbs', '', [
				'breadcrumbs' => $breadcrumbs
			]); ?>
		</div>
		<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-center">
			<div class="lg:col-span-2 order-2 lg:order-1">
				<h1 class="text-h2"><?php the_title(); ?></h1>
				<p class="flex items-center gap-2 uppercase mt-7">
					<?php the_date('F j, Y'); ?>
				</p>
			</div>
			<div class="order-1 lg:order-2">
				<?php the_post_thumbnail('medium', array('class' => 'border border-subtle block w-full md:w-auto')); ?>
			</div>
		</div>
	</header>
	<section class="py-12 lg:py-20">
		<div class="container grid grid-cols-1 lg:grid-cols-4 gap-9 lg:gap-18 items-start">
			<div class="lg:col-span-3 flex flex-col gap-10 lg:gap-20 order-2 lg:order-1">
				<div class="wysiwyg wysiwyg-lg">
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