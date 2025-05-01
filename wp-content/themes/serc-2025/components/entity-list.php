<?php
$title = $args['title'] ?? null;
$entities = $args['entities'] ?? [];
?>

<div class="container py-12 lg:py-24 flex flex-col gap-12 lg:gap-24">
	<?php if ($title) : ?>
		<h2 class="text-h2 text-center"><?php echo $title; ?></h2>
	<?php endif; ?>
	<div class="flex flex-col">
		<?php foreach ($entities as $entity) :
			$image = $entity['entity_image'] ?? null;
			$title = $entity['entity_title'] ?? "";
			$url = $entity['entity_url'] ?? "";
			$url_display = $url;
			if ($url) {
				$url_display = preg_replace('#^https?://#', '', $url);
			}
			$description = $entity['entity_description'] ?? "";
		?>
			<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 items-start gap-8 lg:gap-14 py-10 lg:py-16 px-8 lg:px-14 border-t border-subtle">
				<?php if ($image) : ?>
					<?php echo $image; ?>
				<?php endif; ?>
				<div class="flex flex-col gap-4 md:col-span-2 lg:col-span-4 pr-8 lg:pr-14">
					<?php if ($title) : ?>
						<h3 class="text-h3"><?php echo $title; ?></h3>
					<?php endif; ?>
					<?php if ($url) : ?>
						<p class="body-lg">
							<a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" class="text-brand hover:underline focus:underline outline-0 flex items-center gap-2">
								<?php echo serc_svg("external-link", "text-brand size-5") ?>
								<?php echo $url_display; ?>
							</a>
						</p>
					<?php endif; ?>
					<?php if ($description) : ?>
						<p class="body-lg"><?php echo $description; ?></p>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>