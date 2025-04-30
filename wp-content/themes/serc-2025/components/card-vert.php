<?php
$title = $args['title'] ?? null;
$label_above = $args['label_above'] ?? null;
$label_below = $args['label_below'] ?? null;
$text = $args['text'] ?? null;
$url = $args['url'] ?? null;
$cta = $args['cta'] ?? null;
$image = $args['image'] ?? null;
?>

<article>
	<a href="<?php echo $url; ?>" class="group/card w-full h-full border outline-0 border-[#d9d9d9] transition-all flex flex-col hover:shadow-lg">
		<?php if ($image) : ?>
			<div class="shrink-0">
				<?php echo $image; ?>
			</div>
		<?php endif; ?>
		<div class="border-brand border-t-4 border-solid px-7 py-6 h-full flex flex-col">
			<?php if ($label_above) : ?>
				<p class="mb-4 text-light-surface-strong"><?php echo $label_above; ?></p>
			<?php endif; ?>
			<?php if ($title) : ?>
				<h3 class="text-h5 transition-colors text-light-surface-strong group-hover/card:text-brand"><?php echo $title; ?></h3>
			<?php endif; ?>
			<?php if ($label_below) : ?>
				<p class="mt-2 text-light-surface-strong"><?php echo $label_below; ?></p>
			<?php endif; ?>
			<?php if ($text) : ?>
				<div class="mt-4 mb-6 lg:mb-12 body-sm text-light-surface-muted"><?php echo $text; ?></div>
			<?php endif; ?>
			<?php if ($cta) : ?>
				<p class="font-medium mt-auto text-light-surface-strong group-hover/card:text-brand"><?php echo $cta; ?></p>
			<?php endif; ?>
		</div>
	</a>
</article>