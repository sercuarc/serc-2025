<?php

use Serc2025\Helpers;

$title = get_field('publications_title') ?: (is_admin() ? 'Add a Title (optional)' : "");
$description = get_field('publications_description') ?: (is_admin() ? 'Add a description (optional)' : "");
$button = get_field('publications_button') ?: (is_admin() ? ['title' => 'Add a Button (optional)', 'url' => '#', 'target' => '_self'] : null);
$publication_ids = [];
$technical_report_ids = [];
$publications = Helpers::get_publications_from_field('publications_publications');
?>

<div class="py-16 lg:py-30 bg-light-secondary">
	<div class="container flex flex-col gap-8 lg:gap-14">
		<div>
			<?php if ($title) : ?>
				<h2 class="text-title-1 text-center">
					<?php echo $title; ?>
				</h2>
			<?php endif; ?>
			<?php if ($description) : ?>
				<div class="body-lg text-center w-full max-w-[670px] mx-auto mt:6 lg:mt-8">
					<?php echo $description; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 content-start">
			<?php foreach ($publications as $pub) : ?>
				<?php
				$image = wp_get_attachment_image($pub['image_id'], 'medium', false, ['class' => 'w-full aspect-[11/5] object-cover']);
				get_template_part('components/card-vert', null, [
					'image'   		=> $image ? $image : Helpers::component('placeholder-serc-star'),
					'label_above' => '<span class="flex items-center">' . serc_svg($pub['icon'], 'inline-block text-brand size-5 mr-2') . ' ' . $pub['category'] . '</span>',
					'title'   		=> $pub['title'],
					'text' 				=> $pub['date'] . ' – ' . wp_trim_words($pub['abstract'], 25),
					'url'     		=> $pub['url'],
					'cta' 				=> 'Read More',
				]); ?>
			<?php endforeach; ?>
		</div>
		<?php if ($button) : ?>
			<div class="text-center">
				<a href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target']); ?>" rel="noopener noreferrer" class="btn btn-primary">
					<?php echo esc_html($button['title']); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>