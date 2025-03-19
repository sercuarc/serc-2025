<?php

/**
 * Template Name: Page
 */
?>

<?php get_header(); ?>

<main class="flex flex-col gap-12">

	<section id="Buttons" class="flex flex-col gap-8">
		<h1 class="text-title-2 text-warm-neutral-300">Buttons</h1>
		<div class="flex gap-4">
			<button class="btn btn-primary">.btn.btn-primary</button>
			<button class="btn btn-primary btn-lg">.btn.btn-lg</button>
		</div>
		<div class="flex gap-4">
			<button class="btn btn-secondary">.btn.btn-secondary</button>
			<button class="btn btn-secondary btn-lg">.btn.btn-secondary.btn-lg</button>
		</div>
		<div class="flex gap-4 bg-dark-main p-4">
			<button class="btn btn-tertiary">.btn.btn-tertiary</button>
			<button class="btn btn-tertiary btn-lg">.btn.btn-tertiary.btn-lg</button>
		</div>
	</section>

	<section id="typography" class="flex flex-col gap-8">

		<h1 class="text-title-2 text-warm-neutral-300">Typography</h1>

		<div>
			<h1 class="text-h1">text-h1</h1>
			<h2 class="text-h2">text-h2</h2>
			<h3 class="text-h3">text-h3</h3>
			<h4 class="text-h4">text-h4</h4>
			<h5 class="text-h5">text-h5</h5>
			<h6 class="text-h6">text-h6</h6>
		</div>

		<div>
			<p class="text-title-1">text-title-1</p>
			<p class="text-title-2">text-title-2</p>
		</div>

		<p class="body-lg"><code class="bg-gray-100 mr-1">body-lg</code>This is a <strong>large body text</strong> paragraph. Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

		<p class="body-base"><code class="bg-gray-100 mr-1">body-base</code>This is a <strong>base body text</strong> paragraph. Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

		<p class="body-sm"><code class="bg-gray-100 mr-1">body-sm</code>This is a <strong>small body text</strong> paragraph. Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

	</section>

	<section id="theme-colors" class="flex flex-col gap-8">

		<h1 class="text-title-2 text-warm-neutral-300">Theme Colors</h1>

		<p>Colors can be used as variables in CSS using <code class="text-blue-500">var(--color-<strong>COLOR_NAME</strong>)</code>.</p>
		<p>Likewise, all colors have associtated utility classes such as <code class="text-blue-500">bg-<strong>COLOR_NAME</strong></code>, <code class="text-blue-500">text-<strong>COLOR_NAME</strong></code>, and <code class="text-blue-500">border-<strong>COLOR_NAME</strong></code>.</p>

		<div class="flex flex-col gap-4">
			<?php
			$colorRows = [
				['--color-brand', '--color-brand-light', '--color-brand-hover', '--color-brand-dark'],
				['--color-success', '--color-success-light', '--color-error', '--color-error-light', '--color-alert', '--color-alert-light', '--color-info', '--color-info-light'],
				['--color-light-main', '--color-light-secondary', '--color-light-tertiary', '--color-dark-main', '--color-dark-secondary', '--color-dark-tertiary'],
				['--color-light-surface-strong', '--color-light-surface-muted', '--color-light-surface-normal', '--color-light-surface-subtle', '--color-light-surface-disabled'],
				['--color-dark-surface-strong', '--color-dark-surface-muted', '--color-dark-surface-normal', '--color-dark-surface-subtle', '--color-dark-surface-disabled'],
			];
			foreach ($colorRows as $colors) : ?>
				<div class="flex gap-4">
					<?php foreach ($colors as $color) : ?>
						<div class="w-40 overflow-hidden">
							<div class="aspect-square border-subtle rounded-lg" style="background-color: var(<?php echo $color; ?>);"></div>
							<small class="whitespace-nowrap text-xs"><code><?php echo substr($color, 8); ?></code></small>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>

	</section>

	<section id="primitive-colors" class="flex flex-col gap-8">

		<h1 class="text-title-2 text-warm-neutral-300">Primitive Colors</h1>

		<div class="flex flex-col gap-4">
			<?php
			$colorRows = [
				['--color-red-50', '--color-red-100', '--color-red-200', '--color-red-300', '--color-red-400', '--color-red-500', '--color-red-600', '--color-red-700', '--color-red-800', '--color-red-900', '--color-red-950'],
				['--color-orange-50', '--color-orange-100', '--color-orange-200', '--color-orange-300', '--color-orange-400', '--color-orange-500', '--color-orange-600', '--color-orange-700', '--color-orange-800', '--color-orange-900', '--color-orange-950'],
				['--color-yellow-50', '--color-yellow-100', '--color-yellow-200', '--color-yellow-300', '--color-yellow-400', '--color-yellow-500', '--color-yellow-600', '--color-yellow-700', '--color-yellow-800', '--color-yellow-900', '--color-yellow-950'],
				['--color-mint-50', '--color-mint-100', '--color-mint-200', '--color-mint-300', '--color-mint-400', '--color-mint-500', '--color-mint-600', '--color-mint-700', '--color-mint-800', '--color-mint-900', '--color-mint-950'],
				['--color-blue-50', '--color-blue-100', '--color-blue-200', '--color-blue-300', '--color-blue-400', '--color-blue-500', '--color-blue-600', '--color-blue-700', '--color-blue-800', '--color-blue-900', '--color-blue-950'],
				['--color-sand-50', '--color-sand-100', '--color-sand-200', '--color-sand-300', '--color-sand-400', '--color-sand-500', '--color-sand-600', '--color-sand-700', '--color-sand-800', '--color-sand-900', '--color-sand-950'],
				['--color-gray-50', '--color-gray-100', '--color-gray-200', '--color-gray-300', '--color-gray-400', '--color-gray-500', '--color-gray-600', '--color-gray-700', '--color-gray-800', '--color-gray-900', '--color-gray-950'],
				['--color-neutral-50', '--color-neutral-100', '--color-neutral-200', '--color-neutral-300', '--color-neutral-400', '--color-neutral-500', '--color-neutral-600', '--color-neutral-700', '--color-neutral-800', '--color-neutral-900', '--color-neutral-950'],
				['--color-warm-neutral-50', '--color-warm-neutral-100', '--color-warm-neutral-200', '--color-warm-neutral-300', '--color-warm-neutral-400', '--color-warm-neutral-500', '--color-warm-neutral-600', '--color-warm-neutral-700', '--color-warm-neutral-800', '--color-warm-neutral-900', '--color-warm-neutral-950'],
			];
			foreach ($colorRows as $colors) : ?>
				<div class="flex gap-4">
					<?php foreach ($colors as $color) : ?>
						<div class="w-full overflow-hidden">
							<div class="aspect-square w-full border-subtle rounded-lg" style="background-color: var(<?php echo $color; ?>);"></div>
							<small class="whitespace-nowrap text-xs"><code><?php echo substr($color, 8); ?></code></small>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>

	</section>

</main>


<?php get_footer(); ?>