<?php
$section_title = get_field('text_image_section_title');
?>
<div class="py-16 lg:py-30">
	<div class="container flex flex-col gap-16 lg:gap-24">
		<?php if ($section_title) : ?>
			<h2 class="text-h2 text-center"><?php echo esc_html($section_title); ?></h2>
		<?php endif; ?>
		<?php while (have_rows('text_image')) : the_row(); ?>
			<?php
			$layout = get_row_layout();
			$order = $i % 2 === 0 ? 'text-left' : 'text-right';
			$image_class = $order === 'text-left' ? 'order-0 md:order-1' : 'order-0';
			$text_class = $order === 'text-left' ? 'order-0' : 'order-0 md:order-1';
			$title = "Title";
			$description = '<p>Content about SERC sponsors goes here to highlight these sponsorships by Office of the Under Secretary of Defense for Research and Engineering – (OUSD(R&E)) and U.S. Army Combat Capabilities Development Command Armaments Center.</p><p><span style="font-size:14px; color:#546166;">The Systems Engineering Research Center (SERC) is not an official component of the Department of Defense or any Military Service.</span></p>';
			$link = [
				'title' => 'Learn More',
				'url' => '#',
				'target' => '_self',
			];
			$link_as_button = true;
			$link_style = $link_as_button ? "btn btn-primary" : "text-brand hover:underline focus:underline outline-0";
			$alignment = $layout === "text_gallery" ? "items-center" : "items-start";
			?>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20 <?php echo $alignment; ?>">
				<div class="<?php echo $image_class; ?>">
					<?php if ($layout === "text_gallery"): $imageIds = [21522, 21521, 21520]; ?>
						<div class="flex gap-4 lg:gap-6 flex-wrap">
							<?php foreach ($imageIds as $imageId) : ?>
								<div class="bg-white w-30 h-30 shadow-md flex items-center justify-center p-4">
									<?php echo wp_get_attachment_image($imageId, 'thumbnail', false, ['class' => 'w-full h-full object-contain']); ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php elseif ($layout === "text_image"): $imageId = 21332; ?>
						<?php echo wp_get_attachment_image($imageId, 'medium'); ?>
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
								<a href="<?php echo esc_url($link['url']); ?>" class="<?php echo $link_style; ?>" target="<?php echo esc_attr($link['target']); ?>" rel="noopener noreferrer">
									<?php echo esc_html($link['title']); ?>
								</a>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php endwhile; ?>
	</div>
</div>