<?php

/**
 * Template Name: News Landing
 */

get_header();
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
	<?php get_template_part('components/hero', null, [
		'bg_image' => get_the_post_thumbnail($post, 'large', ['class' => 'hero-bg-image']),
		'title' => 'News',
		'title_class' => 'text-h1',
		'center_y' => true,
		'description' => get_the_content(),
		'description_class' => 'body-lg mt-7',
	]); ?>
	<section class="py-12 lg:py-20">

		<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-12 my-6 lg:my-12">
			<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
				<?php get_template_part('components/card-vert', null, [
					'title' => get_the_title(),
					'url' => get_the_permalink(),
					'label_below' => get_the_date('F j, Y'),
					'text' => get_the_excerpt(),
					'cta' => 'Read More ' . serc_svg('arrow-right', 'inline text-brand size-5 ml-1 transition-transform group-hover/card:translate-x-2'),
					'image' => get_the_post_thumbnail(get_the_ID(), 'small', ['class' => 'block w-full'])
				]); ?>
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