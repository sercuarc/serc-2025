<?php

/**
 * Template Name: Search
 */
?>

<?php get_header(); ?>

<main class="flex flex-col gap-8">

	<div>
		<form action="/">
			<label>
				<strong>Search:</strong><br>
				<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="Search" class="border border-slate-500 p-4 text-lg rounded-lg w-full block" />
			</label>
			<button type="submit" style="display: none">Submit</button>
		</form>
	</div>

	<?php while (have_posts()) : the_post(); ?>
		<article>
			<h2 class="text-2xl"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php echo wp_trim_words(get_the_content(), 30); ?>
		</article>
	<?php endwhile; ?>

	<?php if (!have_posts()) : ?>
		<p>No results found.</p>
	<?php endif; ?>

</main>

<?php get_footer(); ?>