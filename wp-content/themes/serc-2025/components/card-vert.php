<?php
$title = $args['title'] ?? null;
$label_above = $args['label_above'] ?? null;
$label_below = $args['label_below'] ?? null;
$text = $args['text'] ?? null;
$url = $args['url'] ?? null;
$cta = $args['cta'] ?? null;
$image = $args['image'] ?? null;
$contained = $args['contained'] ?? true;
$class = $args['class'] ?? '';

$container_class = $contained ? 'bg-white border border-[#d9d9d9] hover:shadow-lg' : '';
$content_class = $contained ? 'border-brand border-t-4 border-solid px-7 py-6' : 'py-4';
?>

<a href="<?php echo $url; ?>" class="group w-full h-full outline-0 transition-all flex flex-col <?php echo $container_class . ' ' . $class; ?>">
	<?php if ($image) : ?>
		<div class="shrink-0">
			<?php echo $image; ?>
		</div>
	<?php endif; ?>
	<div class="<?php echo $content_class; ?> h-full flex flex-col gap-4">
		<?php if ($label_above) : ?>
			<div class="text-light-surface-strong"><?php echo $label_above; ?></div>
		<?php endif; ?>
		<?php if ($title) : ?>
			<h3 class="text-h5 transition-colors text-light-surface-strong group-hover:text-brand"><?php echo $title; ?></h3>
		<?php endif; ?>
		<?php if ($label_below) : ?>
			<div class="text-light-surface-strong"><?php echo $label_below; ?></div>
		<?php endif; ?>
		<?php if ($text) : ?>
			<div class="body-sm text-light-surface-muted"><?php echo $text; ?></div>
		<?php endif; ?>
		<?php if ($cta) : ?>
			<div class="font-medium mt-auto text-light-surface-strong group-hover:text-brand flex items-center gap-2">
				<span><?php echo $cta; ?></span>
				<?php echo serc_svg('arrow-right', 'text-brand size-5 transition-transform group-hover:translate-x-2'); ?>
			</div>
		<?php endif; ?>
	</div>
</a>