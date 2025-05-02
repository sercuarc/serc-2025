<?php
$title = get_field('banner_title') ?: (is_admin() ? 'Add a Title (optional)' : "");
$description = get_field('banner_description') ?: (is_admin() ? 'Add a description (optional)' : "");
$button = get_field('banner_button') ?: (is_admin() ? ['title' => 'Add a Button (optional)', 'url' => '#', 'target' => '_self'] : null);
?>

<div class="py-12 lg:py-20 bg-light-tertiary w-full max-w-[1416px] mx-auto">
	<div class="container flex flex-col lg:flex-row gap-8 items-center">
		<div class="text-center lg:text-left">
			<?php if ($title) : ?>
				<h2 class="text-title-1">
					<?php echo esc_html($title); ?>
				</h2>
			<?php endif; ?>
			<?php if ($description) : ?>
				<h3 class="text-h3 mt-6 lg:mt-8">
					<?php echo esc_html($description); ?>
				</h3>
			<?php endif; ?>
		</div>
		<?php if ($button) : ?>
			<a href="<?php echo esc_url($button['url']); ?>" class="lg:ml-auto btn btn-primary btn-lg btn-secondary" target="<?php echo esc_attr($button['target']); ?>" rel="noopener noreferrer"><?php echo esc_html($button['title']); ?></a>
		<?php endif; ?>
	</div>
</div>