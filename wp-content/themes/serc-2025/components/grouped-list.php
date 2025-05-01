<?php
$title = $args['title'] ?? null;
$subtitle = $args['subtitle'] ?? null;
$groups = $args['groups'] ?? [];
?>

<div class="bg-light-tertiary py-12 lg:py-24">
	<div class="container flex flex-col gap-12 lg:gap-16">
		<header>
			<?php if ($title) : ?>
				<h2 class="text-h2 text-center"><?php echo $title; ?></h2>
			<?php endif; ?>
			<?php if ($subtitle) : ?>
				<h3 class="text-h4 mt-2 text-center"><?php echo $subtitle; ?></h3>
			<?php endif; ?>
		</header>
		<?php if ($groups) : ?>
			<div class="text-center md:text-left columns-1 md:columns-2 lg:columns-3">
				<?php foreach ($groups as $group) :
					$title = $group['group_title'] ?? null;
					$items = $group['group_items'] ?? [];
				?>
					<div class="break-inside-avoid flex flex-col gap-4 lg:gap-6 mb-4 lg:mb-6">
						<?php if ($title) : ?>
							<h4 class="text-h4"><?php echo $title; ?></h4>
						<?php endif; ?>
						<?php foreach ($items as $item) : ?>
							<?php $name = $item['group_item_name'] ?? null; ?>
							<?php $link = $item['group_item_link'] ?? null; ?>
							<div>
								<?php if ($name) : ?>
									<h5 class="text-base font-semibold"><?php echo $name; ?></h5>
								<?php endif; ?>
								<?php if ($link) : ?>
									<p class="mt-2"><a href="<?php echo $link['url']; ?>" target="_blank" rel="noopener noreferrer" class="text-brand hover:underline focus:underline outline-0 flex items-center gap-2 justify-center md:justify-start"><?php echo serc_svg("external-link", "text-brand size-4") ?><?php echo $link['title']; ?></a></p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>