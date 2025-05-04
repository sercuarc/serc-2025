<?php
$title = get_field('text_image_slider_title') ?: (is_admin() ? 'Add a Title' : "");
$content = get_field('text_image_slider_content') ?: (is_admin() ? 'Add content' : "");
$images = get_field('text_image_slider_images');
$link = get_field('text_image_slider_link');
?>
<style>
	:root {
		--swiper-pagination-bottom: -6px;
		--swiper-pagination-bullet-size: 14px;
		--swiper-pagination-bullet-horizontal-gap: 7px;
		--swiper-pagination-color: #A0A1A1;
		--swiper-pagination-bullet-inactive-color: var(--color-sand-400);
	}

	swiper-container {
		width: 100%;
		height: 100%;
	}

	swiper-slide {
		display: flex;
		justify-content: center;
		align-items: center;
	}

	swiper-slide img {
		display: block;
		width: 100%;
		height: 100%;
		object-fit: cover;
	}
</style>
<div class="py-16 lg:py-30 bg-light-secondary">
	<div class="container grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-18 items-center">
		<div class="relative">
			<?php if ($images) : ?>
				<swiper-container pagination="true">
					<?php foreach ($images as $imageId) : $image = wp_get_attachment_image($imageId, 'medium', false, ['loading' => 'lazy']); ?>
						<swiper-slide>
							<?php echo $image; ?>
						</swiper-slide>
					<?php endforeach; ?>
				</swiper-container>
				<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js" async></script>
			<?php endif; ?>
		</div>
		<div class="flex flex-col gap-4 lg:gap-8">
			<?php if ($title) : ?>
				<h2 class="text-h2"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<?php if ($content) : ?>
				<div class="body-lg">
					<?php echo apply_filters('the_content', $content); ?>
				</div>
			<?php endif; ?>
			<?php if ($link) : ?>
				<p>
					<a href="<?php echo esc_url($link['url']); ?>" class="btn btn-primary btn-lg" target="<?php echo esc_attr($link['target']); ?>" rel="noopener noreferrer">
						<?php echo esc_html($link['title']); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>