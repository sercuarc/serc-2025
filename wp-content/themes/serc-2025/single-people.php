<?php

/**
 * People Single
 */
?>

<?php get_header(); ?>

<main>
	<header class="hero lg:pb-30">
		<div class="container">
			<?php get_template_part('components/breadcrumbs', '', [
				'breadcrumbs' => [
					'People' => get_post_type_archive_link('people'),
					'[CATEGORY]' => '#'
				]
			]); ?>
		</div>
		<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-16 items-center">
			<div class="lg:col-span-2">
				<h1 class="text-h2"><?php the_title(); ?></h1>
				<h2 class="text-h4 mt-6">[JOB TITLE]</h2>
				<p class="uppercase mt-8">
					<?php echo serc_svg("institution", "inline text-brand size-3 mr-1"); ?>
					[INSTITUTE]
				</p>
			</div>
			<div>
				<?php the_post_thumbnail('medium', array('class' => 'aspect-square object-cover')); ?>
			</div>
		</div>
	</header>
	<section class="py-12 lg:py-20">
		<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-start">
			<div class="lg:col-span-2">
				<h3 class="text-[1.75rem] mb-10"><strong>About</strong></h3>
				<div class="wysiwyg wysiwyg-lg">
					<?php the_content(); ?>
				</div>
			</div>
			<div>
				<h3 class="text-[1.75rem] mb-10">
					<?php echo serc_svg("badge", "inline text-brand size-8 mr-1"); ?>
					<strong>Expertise</strong>
				</h3>
				<ul class="text-lg lg:text-xl flex flex-col gap-4">
					<li>[EXPERTISE]</li>
					<li>[EXPERTISE]</li>
					<li>[EXPERTISE]</li>
					<li>[EXPERTISE]</li>
					<li>[EXPERTISE]</li>
					<li>[EXPERTISE]</li>
					<li>[EXPERTISE]</li>
				</ul>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>