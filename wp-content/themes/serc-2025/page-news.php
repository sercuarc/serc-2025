<?php

/**
 * Template Name: News Landing
 */

get_header();
$image = get_the_post_thumbnail($post, 'full');
$page = get_query_var('paged');
$content = get_the_content();
$news_query = new WP_Query([
	'post_type' => 'post',
	'posts_per_page' => 12,
	'paged' => $page ?: 1,
]);
$pagination = paginate_links([
	'type' => 'array',
	'total' => $news_query->max_num_pages,
	'current' => max(1, $page),
	'mid_size' => 1,
	'prev_text' => 'Previous',
	'next_text' => 'Next',
]);
?>

<main>
	<header class="hero <?php if ($image) : ?>hero--inverted hero--with-image<?php endif; ?>">
		<?php if ($image) {
			echo $image;
		} ?>
		<div class="container">
			<h1 class="text-h1">News</h1>
			<?php if ($content) : ?>
				<div class="mt-8">
					<?php echo $content; ?>
				</div>
			<?php endif; ?>
		</div>
	</header>
	<section class="py-12 lg:py-20">

		<?php if ($page > 1) : ?>
			<div class="container">
				<?php get_template_part('components/pagination', null, [
					'pagination' => $pagination
				]); ?>
			</div>
		<?php endif; ?>

		<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-12 my-6 lg:my-12">
			<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="group/card border outline-0 border-[#d9d9d9] transition-all flex flex-col hover:shadow-lg">
					<?php the_post_thumbnail('small', array('class' => 'block w-full')); ?>
					<div class="border-brand border-t-4 border-solid px-7 py-6 h-full flex flex-col">
						<h3 class="text-h5 transition-colors group-hover/card:text-brand"><?php the_title(); ?></h3>
						<p class="mt-2"><?php the_date('F j, Y'); ?></p>
						<div class="mt-4 mb-6 lg:mb-12 body-sm"><?php the_excerpt(); ?></div>
						<p class="font-medium mt-auto">Read More <?php echo serc_svg('arrow-right', 'inline text-brand size-5 ml-1 transition-transform group-hover/card:translate-x-2'); ?></p>
					</div>
				</a>
			<?php endwhile; ?>
		</div>

		<div class="container">
			<?php get_template_part('components/pagination', null, [
				'pagination' => $pagination
			]); ?>
		</div>

		<?php wp_reset_postdata(); ?>
	</section>
</main>

<?php get_footer(); ?>