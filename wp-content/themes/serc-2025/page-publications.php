<?php

/**
 * Template Name: Publications Landing
 */

get_header();

// Query Publications
$publications = wp_cache_get('featured_publications', 'serc');
if (false === $publications) {
	$publications = wp_remote_get(get_site_url() . '/wp-json/serc/v1/publications');
	$publications = json_decode($publications['body']);
	wp_cache_set('featured_publications', $publications, 'serc', 60 * 60 * 24);
}

$view = $_GET['publications-view'] ?? 'cat-1';
?>

<main>
	<?php get_template_part('components/hero', null, [
		'bg_image' => get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'hero-bg-image object-center']),
		'title' => get_the_title(),
		'title_class' => 'text-h1',
		'description' => get_the_content(),
		'description_class' => 'body-lg mt-7',
		'center_y' => true
	]); ?>
	<div class="container py-12 lg:py-16">
		<div class="flex sm:items-end flex-col sm:flex-row gap-4 sm:gap-8 lg:gap-24 pb-8 lg:pb-12">
			<nav class="tab-menu lg:pt-3">
				<?php foreach (['cat-1', 'cat-2', 'cat-3', 'cat-4'] as $category) : ?>
					<?php if ($view === $category) : ?>
						<span class="tab is-active"><?php echo $category; ?></span>
					<?php else : ?>
						<a href="<?php echo get_permalink() . '?view=' . $category; ?>" class="tab"><?php echo $category; ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
		</div>
		<div class="max-w-[806px] mx-auto pt-16 lg:pt-24 flex flex-col items-center gap-7 lg:gap-14">
			<h2 class="text-title-1">Focus Area Title</h2>
			<div class="wysiwyg">
				<p>Focus area description goes here. This is a brief overview of the focus area, its significance, and what kind of publications can be found under this category.</p>
				<p>Additional information about the focus area can be included here. This may include details about the research, methodologies, or any other relevant information that would help the reader understand the context of the publications.</p>
				<p>For more information, you can visit the <a href="<?php echo get_permalink(); ?>">publications page</a> or contact us for further inquiries.</p>
			</div>
			<p class="text-center">
				<a href="<?php echo home_url('search/?query=&doc_types=publications'); ?>" class="btn btn-primary">See All Publications</a>
			</p>
		</div>
		<div class="grid gap-6 md:gap-y-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 pt-16 lg:pt-30 pb-8 lg:pb-16">
			<?php for ($i = 0; $i < 9; $i++) {  ?>
				<?php get_template_part('components/card-vert', null, [
					'title' => 'Title',
					'url' => '#',
					'label_above' => 'Pub Type',
					'text' => 'There is a need to develop Systems Engineering (SE) Guidance for Program Managers that address the correct toolkit inclusive of priorities pertaining to Digital Engineering',
					'cta' => 'Read More ' . serc_svg('arrow-right', 'inline text-brand size-5 ml-1 transition-transform group-hover/card:translate-x-2'),
					'image' => get_the_post_thumbnail(get_the_ID(), 'small', ['class' => 'block w-full'])
				]); ?>
			<?php } ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>