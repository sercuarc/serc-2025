<?php
$title = $args['title'] ?? null;
$label_above = $args['label_above'] ?? null;
$label_below = $args['label_below'] ?? null;
$text = $args['text'] ?? null;
$cta = $args['cta'] ?? null;
$cta_style = $cta && isset($cta['style']) ? $cta['style'] : 'button';
$url = $args['url'] ?? null;
$image = $args['image'] ?? null;
$reversed = $args['reversed'] ?? false;

$text_order = $reversed ? 'order-2' : 'order-2 md:order-1';
$image_order = $reversed ? 'order-1' : 'order-1 md:order-2';
?>

<article class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 xl:gap-20 items-start">
	<div class="flex flex-col gap-4 w-full <?php echo $text_order; ?>">
		<?php if ($label_above) : ?>
			<div class="font-medium"><?php echo $label_above; ?></div>
		<?php endif; ?>

		<?php if ($title) : ?>
			<h3 class="font-semibold text-[24px] lg:text-[28px] leading-[1.4] mb-2">
				<?php if ($url) : ?>
					<a href="<?php echo $url; ?>" class="text-inherit hover:text-brand focus:text-brand outline-0"><?php echo $title; ?></a>
				<?php else : ?>
					<?php echo $title; ?>
				<?php endif; ?>
			</h3>
		<?php endif; ?>

		<?php if ($label_below) : ?>
			<div class="font-medium"><?php echo $label_below; ?></div>
		<?php endif; ?>

		<?php if ($text) : ?>
			<p><?php echo $text; ?></p>
		<?php endif; ?>

		<?php if ($cta) : ?>
			<p class="pt-6 md:pt-12 mt-auto">
				<?php if ($cta_style === 'button') : ?>
					<a href="<?php echo $cta['url']; ?>" class="btn btn-primary inline-block"><?php echo $cta['text']; ?></a>
				<?php else : ?>
					<a href="<?php echo $cta['url']; ?>" class="group font-medium hover:text-brand focus:text-brand outline-0 inline-flex items-center gap-2">
						<span><?php echo $cta['text']; ?></span>
						<?php echo serc_svg("arrow-right", "inline text-brand size-5 transition-transform group-hover:translate-x-2") ?>
					</a>
				<?php endif; ?>
			</p>
		<?php endif; ?>
	</div>
	<?php if ($image) : ?>
		<div class="w-full <?php echo $image_order; ?>">
			<?php if ($url) : ?>
				<a href="<?php echo $url; ?>" class="text-inherit hover:text-brand focus:text-brand outline-0">
					<?php echo $image; ?>
				</a>
			<?php else : ?>
				<?php echo $image; ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</article>