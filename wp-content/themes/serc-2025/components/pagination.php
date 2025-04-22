<?php $pagination = isset($args['pagination']) ? $args['pagination'] : []; ?>

<div class="my-10 flex flex-wrap items-center justify-center gap-1 lg:gap-7 text-base lg:text-lg font-medium">
	<?php foreach ($pagination as $item) : ?>
		<?php
		preg_match('/href="([^"]+)"/', $item, $matches);
		$href = $matches[1] ?? null;
		$text = strip_tags($item);
		?>
		<?php if ($text === 'Previous') : ?>
			<a href="<?php echo $href; ?>"
				class="hidden sm:flex items-center justify-center gap-3 hover:text-brand mr-2 md:mr-0">
				<svg width="10" height="17" viewBox="0 0 10 17" fill="none" class="text-brand" xmlns="http://www.w3.org/2000/svg">
					<path d="M8.51453 1.4043L1.45672 8.4621L8.51453 15.5199" stroke="currentColor" stroke-width="1.76445" />
				</svg>
				Previous
			</a>
		<?php elseif ($text === 'Next') : ?>
			<a href="<?php echo $href; ?>"
				class="hidden sm:flex items-center justify-center gap-3 hover:text-brand ml-2 md:ml-0">
				Next
				<svg width="10" height="17" viewBox="0 0 10 17" fill="none" class="text-brand" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.49133 1.4043L8.54914 8.4621L1.49133 15.5199" stroke="currentColor" stroke-width="1.76445" />
				</svg>
			</a>
		<?php else : ?>
			<span class="flex items-center gap-3">
				<?php if ($text === '&hellip;') : ?>
					<span class="flex items-center justify-center size-9 text-lg lg:text-2xl text-dark-main/50">...</span>
				<?php elseif ($href) : ?>
					<a href="<?php echo $href; ?>"
						class="flex items-center justify-center size-9 text-lg lg:text-2xl text-dark-main/50 hover:text-brand">
						<?php echo $text; ?>
					</a>
				<?php else : ?>
					<span
						class="flex items-center justify-center size-9 text-lg lg:text-2xl text-dark-main/50 bg-brand text-white">
						<?php echo $text; ?>
					</span>
				<?php endif; ?>
			</span>
		<?php endif; ?>
	<?php endforeach; ?>
</div>