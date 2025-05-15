<?php

$tabs = get_field('tabs');
if (!$tabs && is_admin()) {
	echo "<p>Add tabbed content</p>";
	return;
}
?>

<div class="container py-20 lg:py-30">
	<div data-tabs class="w-full max-w-[825px] mx-auto flex flex-col gap-8 lg:gap-12">
		<?php get_template_part("components/tab-menu", null, [
			'active_id' => sanitize_title($tabs[0]['tab_name']),
			'items' => array_map(fn($tab) => ['id' => sanitize_title($tab['tab_name']), 'text' => $tab['tab_name']], $tabs)
		]); ?>
		<div class="tab-content-wrapper">
			<?php $count = 0;
			foreach ($tabs as $tab) : $slug = sanitize_title($tab['tab_name']) ?>
				<div data-tab-content id="<?php echo $slug ?>" class="tab-content wysiwyg <?php echo $count === 0 ? 'is-active' : '' ?>">
					<?php echo apply_filters('the_content', $tab['tab_content']) ?>
				</div>
			<?php $count++;
			endforeach; ?>
		</div>
	</div>
</div>