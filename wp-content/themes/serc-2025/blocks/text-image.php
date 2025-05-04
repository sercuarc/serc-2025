<?php
$section_title = get_field('text_image_section_title') ?: (is_admin() ? 'Add a Section Title (optional)' : "");
?>
<div class="py-16 lg:py-30">
	<div class="container flex flex-col gap-16 lg:gap-24">
		<?php if ($section_title) : ?>
			<h2 class="text-h2 text-center"><?php echo esc_html($section_title); ?></h2>
		<?php endif; ?>
		<?php while (have_rows('text_image')) : the_row(); ?>
			<?php
			$layout = get_row_layout();
			$order = get_sub_field('image_text_order');
			$image_class = $order === 'image-right' ? 'order-0 md:order-1' : 'order-0';
			$text_class = $order === 'image-right' ? 'order-0' : 'order-0 md:order-1';
			$title = get_sub_field('text_image_title') ?: (is_admin() ? 'Add a title' : "");
			$description = get_sub_field('text_image_description') ?: (is_admin() ? '<p>Add content...</p>' : "");
			$link = get_sub_field('text_image_link');
			$link_as_button = get_sub_field('text_image_link_as_button');
			$link_style = $link_as_button ? "btn btn-primary" : "text-brand hover:underline focus:underline outline-0";
			$alignment = $layout === "text_gallery" ? "items-center" : "items-start";
			?>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20 <?php echo $alignment; ?>">
				<div class="<?php echo $image_class; ?>">
					<?php if ($layout === "text_gallery"): $imageIds = get_sub_field('text_image_gallery'); ?>
						<div class="flex gap-4 lg:gap-6 flex-wrap">
							<?php if (! empty($imageIds)) : ?>
								<?php foreach ($imageIds as $imageId) : ?>
									<div class="bg-white w-30 h-30 shadow-md flex items-center justify-center p-4">
										<?php echo wp_get_attachment_image($imageId, 'thumbnail', false, ['class' => 'w-full h-full object-contain']); ?>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<?php elseif ($layout === "text_image"): $imageId = get_sub_field('text_image_image'); ?>
						<?php echo $imageId ? wp_get_attachment_image($imageId, 'medium') : ""; ?>
					<?php endif; ?>
				</div>
				<div class="<?php echo $text_class; ?>">
					<div class="flex flex-col gap-4 lg:gap-6">
						<h3 class="text-h3"><?php echo $title; ?></h3>
						<div class="wysiwyg !gap-4">
							<?php echo apply_filters('the_content', $description); ?>
						</div>
						<?php if ($link) : ?>
							<p>
								<a href="<?php echo esc_url($link['url']); ?>" class="<?php echo $link_style; ?> flex items-center gap-2" target="<?php echo esc_attr($link['target']); ?>" rel="noopener noreferrer">
									<?php
									$is_external = strpos($link['url'], home_url()) === false;
									if ($is_external) {
										echo serc_svg("external-link", "size-4");
									}
									?>
									<?php echo esc_html($link['title']); ?>
									<?php if (! $is_external) {
										echo serc_svg("arrow-right", "size-4");
									} ?>
								</a>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php endwhile; ?>
	</div>
</div>