<?php
$title = get_field('wysiwyg_title') ?: (is_admin() ? 'Add a Title (Optional)' : "");
$content = get_field('wysiwyg_content') ?: (is_admin() ? '<p>Add some content...</p>' : "");
$button = get_field('wysiwyg_button') ?: (is_admin() ? ['title' => 'Add a Button (Optional)', 'url' => '#', 'target' => '_self'] : null);
?>

<div class="py-16 lg:py-30">
	<div class="container flex flex-col gap-8 lg:gap-14">
		<?php if ($title) : ?>
			<h2 class="text-h2 text-center">
				<?php echo esc_html($title); ?>
			</h2>
		<?php endif; ?>
		<?php if ($content) : ?>
			<div class="wysiwyg wysiwyg--lg w-full max-w-[780px] mx-auto">
				<?php echo apply_filters('the_content', $content); ?>
			</div>
		<?php endif; ?>
		<?php if ($button) : ?>
			<div class="text-center">
				<a href="<?php echo esc_url($button['url']); ?>" class="btn btn-primary btn-lg" target="<?php echo esc_attr($button['target']); ?>" rel="noopener noreferrer"><?php echo esc_html($button['title']); ?></a>
			</div>
		<?php endif; ?>
	</div>
</div>