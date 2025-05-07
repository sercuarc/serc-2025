<?php

/**
 * Default Page
 */
?>

<?php get_header(); ?>

<main>
	<?php
	// Get the post content
	$content = get_the_content();

	// Parse the blocks in the content
	$blocks = parse_blocks($content);

	if (! empty($blocks)) {

		// Check if the first block is a 'hero' block
		if ($blocks[0]['blockName'] !== 'acf/hero') {
			// Render a default hero with the page title
			get_template_part('components/hero', null, [
				'title' => get_the_title(),
				'center_y' => true,
			]);
		}

		// Loop through each block
		foreach ($blocks as $block) {
			echo render_block($block);
		}
	}

	?>
</main>

<?php get_footer(); ?>