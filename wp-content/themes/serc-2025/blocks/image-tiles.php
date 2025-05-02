<?php
$title = get_field('image_tiles_title') ?: (is_admin() ? 'Add a Title (optional)' : "");
$description = get_field('image_tiles_description') ?: (is_admin() ? 'Add a description (optional)' : "");
$images = get_field('image_tiles_images') ?: null;
?>

<div class="py-16 lg:py-30 bg-light-secondary">
	<div class="container flex flex-col gap-8 lg:gap-14">
		<?php if ($title) : ?>
			<h2 class="text-h2 text-center">
				<?php echo esc_html($title); ?>
			</h2>
		<?php endif; ?>
		<?php if ($description) : ?>
			<div class="body-lg text-center w-full max-w-[780px] mx-auto">
				<?php echo $description; ?>
			</div>
		<?php endif; ?>
		<div class="flex gap-4 flex-wrap justify-center">
			<?php if (! $images && is_admin()) : ?>
				<?php for ($i = 0; $i < 5; $i++) : ?>
					<div class="bg-white w-30 h-30 shadow-md flex items-center justify-center">
						<div class="rounded-full bg-light-secondary size-16"></div>
					</div>
				<?php endfor; ?>
			<?php else : ?>
				<?php foreach ($images as $imageId) : ?>
					<div class="bg-white w-30 h-30 shadow-md flex items-center justify-center p-4">
						<?php echo wp_get_attachment_image($imageId, 'thumbnail', false, ['class' => 'w-full h-full object-contain']); ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</div>