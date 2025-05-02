<?php

/**
 * Template Name: Publications Landing
 */

use Serc2025\Helpers;

get_header();

// Query Publications


$focus_areas = array_map(function ($area) {
	$area['slug'] = sanitize_title($area['focus_area_title']);
	return $area;
}, get_field('focus_areas') ?: []);
$view = $_GET['publications-view'] ?? $focus_areas[0]['slug'] ?? '';
$active_focus_area = array_filter($focus_areas, function ($area) use ($view) {
	return $area['slug'] === $view;
});
$active_focus_area = array_values($active_focus_area)[0] ?? $focus_areas[0] ?? null;
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
				<?php if ($focus_areas) : ?>
					<?php foreach ($focus_areas as $focus_area) : ?>
						<?php if ($view === $focus_area['slug']) : ?>
							<span class="tab is-active"><?php echo $focus_area['focus_area_title']; ?></span>
						<?php else : ?>
							<a href="<?php echo get_permalink() . '?publications-view=' . $focus_area['slug']; ?>" class="tab"><?php echo $focus_area['focus_area_title']; ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</nav>
		</div>
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
				<?php foreach ($active_focus_area['focus_area_publications'] as $pub) {
					$is_tech_report = $pub['publication_type'] === 'technical-reports';
					$pub_endpoint = 'https://web.sercuarc.org/api/' . $pub['publication_type'] . '/' . $pub['publication_id'];
					$pub_data = wp_remote_get($pub_endpoint);
					if (is_wp_error($pub_data)) {
						if (is_user_logged_in()) {
							echo '<div class="border border-brand text-brand p-4">' . serc_svg('exclamation-circle', 'inline-block text-brand size-5 mr-2') . '' . $pub_data->get_error_message() . '</div>';
						}
						continue;
					}
					$pub_data = json_decode($pub_data['body'], true);
					$pub_data_key = $is_tech_report ? 'tr' : 'pub';
					if (! isset($pub_data[$pub_data_key])) {
						if (is_user_logged_in()) {
							echo '<div class="border border-brand text-brand p-4">' . serc_svg('exclamation-circle', 'inline-block text-brand size-5 mr-2') . 'Invalid ID - ' . $pub['publication_type'] . ':' . $pub['publication_id'] . '</div>';
						}
						continue;
					}
					$pub_data = $pub_data[$pub_data_key];
					$category = $is_tech_report ? 'TECHNICAL REPORT' : strtoupper($pub_data['category']);
					$image_id = $pub['publication_image'];
					if ($image_id) {
						$image = wp_get_attachment_image($image_id, 'small', false, ['class' => 'w-full aspect-[11/5] object-cover']);
					} else {
						$image = null;
					}
					get_template_part('components/card-vert', null, [
						'image' => $image ?? '<div class="relative bg-light-tertiary aspect-[11/5] overflow-hidden">' . serc_svg("serc-star", "absolute text-brand w-3/4 aspect-square left-1/4 bottom-0 translate-y-1/2 opacity-10") . '</div>',
						'label_above' => '<span class="flex items-center">' . serc_svg(Helpers::getCategoryIconHandle($category), 'inline-block text-brand size-5 mr-2') . ' ' . $category . '</span>',
						'title' => $pub_data['title'],
						'url' => home_url('documents/' . $pub['publication_type'] . '/' . $pub_data['id']),
						'text' => $pub_data['abstract'] ? substr(strip_tags($pub_data['abstract']), 0, 100) . '...' : '',
						'cta' => 'Read More ' . serc_svg('arrow-right', 'inline text-brand size-5 ml-1 transition-transform group-hover/card:translate-x-2'),
					]);
				} ?>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>