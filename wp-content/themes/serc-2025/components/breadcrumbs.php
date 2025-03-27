<?php $breadcrumbs = isset($args['breadcrumbs']) ? $args['breadcrumbs'] : []; ?>

<?php if (!empty($breadcrumbs)): ?>
	<nav class="text-base font-medium">
		<ol class="flex gap-3">
			<?php
			$count = 0;
			foreach ($breadcrumbs as $label => $url): ?>
				<li>
					<?php if ($count > 0) : ?>
						<?php echo serc_svg("chevron-right", "inline size-[10px] mr-2"); ?>
					<?php endif; ?>
					<?php if (! empty($url)) : ?>
						<a href="<?php echo $url; ?>" class="hover:text-brand transition-colors"><?php echo $label; ?></a>
					<?php else : ?>
						<span><?php echo $label; ?></span>
					<?php endif; ?>
				</li>
				<?php $count++; ?>
			<?php endforeach; ?>
		</ol>
	</nav>
<?php endif; ?>