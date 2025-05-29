<?php

/**
 * Template Name: Publications Landing
 */

use Serc2025\Helpers;

get_header();

$focus_areas = array_map(function ($area) {
	$area['slug'] = sanitize_title($area['focus_area_title']);
	return $area;
}, get_field('focus_areas') ?: []);
$view = $_GET['publications-view'] ?? $focus_areas[0]['slug'] ?? '';
$active_focus_area = array_filter($focus_areas, function ($area) use ($view) {
	return $area['slug'] === $view;
});
$active_focus_area = array_values($active_focus_area)[0] ?? $focus_areas[0] ?? null;
$publications = [];
if ($active_focus_area) {
	$publications = Helpers::get_publications_from_field($active_focus_area['focus_area_publications']);
}
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
		<?php if ($focus_areas) : ?>
			<div data-tabs class="md:pb-8 lg:pb-12">
				<p class="md:hidden text-sm font-medium mb-2" style="color:#414243">Showing Publications for:</p>
				<?php
				get_template_part("components/tab-menu", null, [
					'active_id' => $active_focus_area['slug'],
					'items' => array_map(fn($item) => ['id' => $item['slug'], 'url' => get_permalink() . '?publications-view=' . $item['slug'], 'text' => $item['focus_area_title']], $focus_areas)
				]);
				?>
			</div>
		<?php endif; ?>
		<?php if ($active_focus_area) : ?>
			<div class="max-w-[806px] mx-auto pt-16 lg:pt-24 flex flex-col items-center gap-7 lg:gap-14">
				<h2 class="text-title-1"><?php echo $active_focus_area['focus_area_title']; ?></h2>
				<div class="wysiwyg">
					<?php echo apply_filters('the_content', $active_focus_area['focus_area_description']); ?>
				</div>
				<p class="text-center">
					<a href="<?php echo home_url('search/?query=&doc_types=publications'); ?>" class="btn btn-primary">See All Publications</a>
				</p>
			</div>
			<div class="grid gap-6 md:gap-y-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 pt-16 lg:pt-30 pb-8 lg:pb-16">
				<?php foreach ($publications as $pub) {
					$image_id = $pub['image_id'] ?? null;
					$image = wp_get_attachment_image($image_id, 'small', false, ['class' => 'w-full aspect-[11/5] object-cover']);
					$icon = $pub['icon'] ?? 'paper';
					$category = $pub['category'] ?? 'Publication';
					get_template_part('components/card-vert', null, [
						'image' => $image ? $image : Helpers::component('placeholder-serc-star'),
						'label_above' => '<span class="flex items-center">' . serc_svg($icon, 'inline-block text-brand size-5 mr-2') . ' ' . $category . '</span>',
						'title' => $pub['title'] ?? '',
						'url' => $pub['url'] ?? '',
						'text' => empty($pub['abstract']) ? '' : substr(strip_tags($pub['abstract']), 0, 100) . '...',
						'cta' => 'Read More',
					]);
				} ?>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>