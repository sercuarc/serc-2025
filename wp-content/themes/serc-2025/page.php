<?php

/**
 * Template Name: Page
 */
?>

<?php get_header(); ?>

<main class="container flex flex-col gap-20">

	<pre>
		<?php var_dump($_SERVER); ?>
	</pre>

	<section id="text-fields" class="flex flex-col gap-8">
		<h1 class="text-title-2 text-gray-300">Text Fields </h1>
		<div class="flex items-start gap-12 ">
			<div class="field field-text w-full">
				<label class="label" for="example">Default Field</label>
				<input type="text" name="example" id="example" value="Default Field" />
				<span class="hint">.field.field-text</span>
			</div>
			<div class="field field-text has-error w-full ">
				<label class="label" for="example">Error Field</label>
				<div class="relative">
					<input type="text" name="example" id="example" value="Error Field">
					<svg class="icon">
						<?php echo serc_svg('exclamation-circle'); ?>
					</svg>
				</div>
				<span class="hint">.field.field-text.has-error</span>
			</div>
			<div class="field field-text is-disabled w-full">
				<label class="label" for="example">Disabled Field</label>
				<div class="relative">
					<input disabled type="text" name="example" id="example" value="Disabled Field">
					<svg class="icon"><?php echo serc_svg('lock'); ?></svg>
				</div>
				<span class="hint">.field.field-text.is-disabled</span>
			</div>
		</div>
		<div class="field field-text field-text-lg w-full">
			<label class="label" for="example">Large Input</label>
			<input type="text" name="example" id="example" value="Large input field" />
			<span class="hint">.field.field-text.field-text-lg</span>
		</div>
		<div class="flex items-start gap-12">
			<div class="field field-text w-full">
				<label class="label" for="example">Default Textarea</label>
				<textarea name="example" id="example">Default Textarea</textarea>
				<span class="hint">Hint or error message</span>
			</div>
			<div class="field field-text has-error w-full">
				<label class="label" for="example">.has-error textarea</label>
				<div class="relative">
					<textarea name="example" id="example">Error Textarea</textarea>
					<svg class="icon"><?php echo serc_svg('exclamation-circle'); ?></svg>
				</div>
				<span class="hint">Hint or error message</span>
			</div>
			<div class="field field-text is-disabled w-full">
				<label class="label" for="example">.is-disabled textarea</label>
				<div class="relative">
					<textarea disabled name="example" id="example">Disabled Textarea</textarea>
					<svg class="icon"><?php echo serc_svg('lock'); ?></svg>
				</div>
				<span class="hint">Hint or error message</span>
			</div>
		</div>
	</section>

	<section id="select-fields" class="flex flex-col gap-8">
		<h1 class="text-title-2 text-gray-300">Select Fields</h1>
		<div class="flex items-start gap-12 ">
			<div class="field field-select w-full">
				<label class="label" for="example">Default Select</label>
				<select name="example" id="example">
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
				</select>
				<span class="hint">Hint or error message</span>
			</div>
			<div class="field field-select has-error w-full">
				<label class="label" for="example">.has-error Select</label>
				<div class="relative">
					<select name="example" id="example">
						<option value="1">Option 1</option>
						<option value="2">Option 2</option>
						<option value="3">Option 3</option>
					</select>
					<svg class="icon"><?php echo serc_svg('exclamation-circle'); ?></svg>
				</div>
				<span class="hint">Hint or error message</span>
			</div>
			<div class="field field-select is-disabled w-full ">
				<label class="label" for="example">.is-disabled Select </label>
				<div class="relative">
					<select disabled name="example" id="example">
						<option value="1">Option 1</option>
						<option value="2">Option 2</option>
						<option value="3">Option 3</option>
					</select>
					<svg class="icon"><?php echo serc_svg('lock'); ?></svg>
				</div>
				<span class="hint">Hint or error message</span>
			</div>
		</div>
		<div>
			<div class="field field-select field-select-sm inline-flex">
				<label class="label" for="example">Small Select</label>
				<select name="example" id="example">
					<option value="1">Small Option 1</option>
					<option value="2">Small Option 2</option>
					<option value="3">Small Option 3</option>
				</select>
				<span class="hint">Hint or error message</span>
			</div>
		</div>
		<div class="flex items-start gap-12">
			<div class="field field-checkbox">
				<input type="checkbox" name="default-checkbox" id="default-checkbox">
				<label class="label" for="default-checkbox">Default Checkbox</label>
			</div>
			<div class="field field-radio">
				<input type="radio" name="default-radio" id="default-radio">
				<label class="label" for="default-radio">Default Radio</label>
			</div>
			<div class="field field-checkbox has-error">
				<input type="checkbox" name="error-checkbox" id="error-checkbox">
				<label class="label" for="error-checkbox">Error Checkbox</label>
			</div>
			<div class="field field-radio has-error">
				<input type="radio" name="error-radio" id="error-radio">
				<label class="label" for="error-radio">Error Radio</label>
			</div>
			<div class="field field-checkbox is-disabled">
				<input disabled type="checkbox" name="disabled-checkbox" id="disabled-checkbox">
				<label class="label" for="disabled-checkbox">Disabled Checkbox</label>
			</div>
			<div class="field field-radio is-disabled">
				<input disabled type="radio" name="disabled-radio" id="disabled-radio">
				<label class="label" for="disabled-radio">Disabled Radio</label>
			</div>
		</div>
		<div class="flex items-start gap-12">
			<div class="field field-toggle">
				<input type="checkbox" name="default-toggle " id="default-toggle">
				<label class="label" for="default-toggle">Default Toggle</label>
				<span class="icon"><?php echo serc_svg('check'); ?> </span>
			</div>
		</div>
	</section>

	<section id="Buttons" class="flex flex-col gap-8">
		<h1 class="text-title-2 text-gray-300">Buttons</h1>
		<div class="flex items-start gap-4">
			<button class="btn btn-primary">.btn.btn-primary</button>
			<button class="btn btn-secondary">.btn.btn-secondary</button>
			<button class="btn btn-outline">.btn.btn-outline</button>
		</div>
		<div class="flex items-start gap-4">
			<button class="btn btn-primary btn-lg">.btn.btn-primary.btn-lg</button>
			<button class="btn btn-secondary btn-lg">.btn.btn-secondary.btn-lg</button>
			<button class="btn btn-outline btn-lg">.btn.btn-outline.btn-lg</button>
		</div>
		<div class="flex items-start flex-wrap gap-4 bg-dark-tertiary p-4">
			<h1 class="text-h5 text-gray-100 w-full">Inverted Buttons </h1>
			<button class="btn btn-inverted">.btn.btn-inverted</button>
			<button class="btn btn-inverted-outline">.btn.btn-inverted-outline</button>
			<button class="btn btn-inverted btn-lg">.btn.btn-inverted.btn-lg</button>
			<button class="btn btn-inverted-outline btn-lg">.btn.btn-inverted-outline.btn-lg</button>
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

		<div class="wysiwyg bg-gray-50 p-8">
			<pre><code>.wysiwyg</code></pre>
			<h1>Heading 1</h1>
			<h2>Heading 2</h2>
			<h3>Heading 3</h3>
			<h4>Heading 4</h4>
			<h5>Heading 5</h5>
			<h6>Heading 6</h6>
			<p>This is a <strong>WYSIWYG</strong> paragraph. It has <a href="#">a link</a> in it. Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			<p>
			<blockquote>This is a <strong>blockquote</strong> paragraph.</blockquote>
			</p>
		</div>

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