<?php

/**
 * Brand Elements - Admin only
 */

if (! is_user_logged_in()) {
	header('Location: /');
	exit;
}
?>

<?php get_header(); ?>

<main>

	<?php get_template_part('components/hero', null, [
		'title' => 'Basic Hero',
		'center_y' => true
	]); ?>

	<?php get_template_part('components/hero', null, [
		'title' => 'Hero with Subtitle & Image',
		'subtitle' => 'This is the subtitle',
		'bg_image' => '<img class="hero-bg-image" src="https://plus.unsplash.com/premium_photo-1679756099015-b06104fff761?fm=jpg&amp;q=60&amp;w=3000&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="nasa satellite" style="object-position:center">',
		'center_y' => true
	]); ?>

	<?php get_template_part('components/hero', null, [
		'title' => 'Hero with Breadcrumbs & Side Image',
		'subtitle' => 'This is the subtitle',
		// 'description' => 'This is the description',
		'custom_html' => '<div class="mt-6"><a href="#" class="btn btn-primary btn-lg">Primary Button</a>&nbsp;<a href="#" class="btn btn-outline btn-lg">Outline Button</a></div>',
		'right_column' => '<img class="hero-image" src="https://plus.unsplash.com/premium_photo-1679756099015-b06104fff761?fm=jpg&amp;q=60&amp;w=3000&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="nasa satellite" style="object-position:center">',
		'breadcrumbs' => ['Breadcrumbs' => '#', 'Parent' => '#', 'Page' => '']
	]); ?>

	<div class="container flex flex-col gap-20 mt-16">

		<section id="text-fields" class="flex flex-col gap-8 test">
			<h1 class="text-title-2 text-gray-300">Text Fields </h1>
			<div class="flex flex-col lg:flex-row items-start gap-12 ">
				<div class="field field-text w-full">
					<label class="label" for="example">Default Field</label>
					<input type="text" name="example" id="example" value="Default Field" />
					<span class="hint">.field.field-text</span>
				</div>
				<div class="field field-text has-error w-full">
					<label class="label" for="example">Error Field 1</label>
					<div class="relative">
						<input type="text" name="example" id="example" value="Error Field">
						<?php echo serc_svg("exclamation-circle"); ?>
					</div>
					<span class="hint">.field.field-text.has-error</span>
				</div>
				<div class="field field-text is-disabled w-full">
					<label class="label" for="example">Disabled Field</label>
					<div class="relative">
						<input disabled type="text" name="example" id="example" value="Disabled Field">
						<?php echo serc_svg("lock"); ?>
					</div>
					<span class="hint">.field.field-text.is-disabled</span>
				</div>
			</div>
			<div class="field field-text field-text-lg w-full">
				<label class="label" for="example">Large Input</label>
				<input type="text" name="example" id="example" value="Large input field" />
				<span class="hint">.field.field-text.field-text-lg</span>
			</div>
			<div class="flex flex-col lg:flex-row items-start gap-12">
				<div class="field field-text w-full">
					<label class="label" for="example">Default Textarea</label>
					<textarea name="example" id="example">Default Textarea</textarea>
					<span class="hint">Hint or error message</span>
				</div>
				<div class="field field-text has-error w-full">
					<label class="label" for="example">.has-error textarea</label>
					<div class="relative">
						<textarea name="example" id="example">Error Textarea</textarea>
						<?php echo serc_svg("exclamation-circle"); ?>
					</div>
					<span class="hint">Hint or error message</span>
				</div>
				<div class="field field-text is-disabled w-full">
					<label class="label" for="example">.is-disabled textarea</label>
					<div class="relative">
						<textarea disabled name="example" id="example">Disabled Textarea</textarea>
						<?php echo serc_svg("lock"); ?>
					</div>
					<span class="hint">Hint or error message</span>
				</div>
			</div>
		</section>

		<section id="select-fields" class="flex flex-col gap-8">
			<h1 class="text-title-2 text-gray-300">Select Fields</h1>
			<div class="flex flex-col lg:flex-row items-start gap-12 ">
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
						<?php echo serc_svg("exclamation-circle"); ?>
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
						<?php echo serc_svg("lock"); ?>
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
			<div class="flex flex-col lg:flex-row items-start gap-12">
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
			<div class="flex flex-col lg:flex-row items-start gap-12">
				<div class="field field-toggle">
					<input type="checkbox" name="default-toggle " id="default-toggle">
					<label class="label" for="default-toggle">Default Toggle </label>
					<?php echo serc_svg("check"); ?>
				</div>
			</div>
		</section>

		<section id="Buttons" class="flex flex-col gap-8">
			<h1 class="text-title-2 text-gray-300">Buttons</h1>
			<div class="flex flex-col lg:flex-row items-start gap-4">
				<button class="btn btn-primary">.btn.btn-primary</button>
				<button class="btn btn-secondary">.btn.btn-secondary</button>
				<button class="btn btn-outline">.btn.btn-outline</button>
			</div>
			<div class="flex flex-col lg:flex-row items-start gap-4">
				<button class="btn btn-primary btn-lg">.btn.btn-primary.btn-lg</button>
				<button class="btn btn-secondary btn-lg">.btn.btn-secondary.btn-lg</button>
				<button class="btn btn-outline btn-lg">.btn.btn-outline.btn-lg</button>
			</div>
			<div class="flex flex-col lg:flex-row items-start flex-wrap gap-4 bg-dark-tertiary p-4">
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
				<h1 class="text-h1">Text H1</h1>
				<h2 class="text-h2">Text H2</h2>
				<h3 class="text-h3">Text H3</h3>
				<h4 class="text-h4">Text H4</h4>
				<h5 class="text-h5">Text H5</h5>
				<h6 class="text-h6">Text H6</h6>
			</div>

			<div>
				<p class="text-title-1">Text Title 1</p>
				<p class="text-title-2">Text Title 2</p>
			</div>

			<p class="label-lg">Label Large</p>
			<p class="label-base">Label Base</p>
			<p class="label-sm">Label Small</p>

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
					['--color-brand-light', '--color-brand', '--color-brand-hover', '--color-brand-dark'],
					['--color-light-main', '--color-light-secondary', '--color-light-tertiary'],
					['--color-dark-surface-strong', '--color-dark-surface-muted', '--color-dark-surface-normal', '--color-dark-surface-subtle', '--color-dark-surface-disabled'],
					['--color-dark-main', '--color-dark-secondary', '--color-dark-tertiary'],
					['--color-light-surface-strong', '--color-light-surface-muted', '--color-light-surface-normal', '--color-light-surface-subtle', '--color-light-surface-disabled'],
					['--color-success-light', '--color-success-medium', '--color-success', '--color-error-light', '--color-error-medium', '--color-error'],
					['--color-alert-light', '--color-alert-medium', '--color-alert', '--color-info-light', '--color-info-medium', '--color-info'],
				];
				foreach ($colorRows as $colors) : ?>
					<div class="flex gap-4">
						<?php foreach ($colors as $color) : ?>
							<div class="w-40 overflow-hidden">
								<div class="aspect-square border border-subtle rounded-lg" style="background-color: var(<?php echo $color; ?>);"></div>
								<small class="whitespace-nowrap text-xs"><code><?php echo substr($color, 8); ?></code></small>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>

		</section>

	</div>

</main>

<?php get_footer(); ?>