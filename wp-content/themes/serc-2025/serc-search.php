<?php

/**
 * Template Name: SERC Search
 */

?>

<?php get_header(); ?>

<?php $search_query = get_query_var('query'); ?>

<?php $filters = [
	'events-news' => 'Events / News',
	'media' => 'Media',
	'people' => 'People',
	'publications' => 'Publications',
	'resources' => 'Resources',
]; ?>

<main>

	<div class="hero bg-light-tertiary py-20">
		<form class="container flex flex-col gap-6">
			<h1 class="text-title-1">Search<?php echo $search_query ? " Results" : ""; ?></h1>
			<div class="flex gap-2 mt-4">
				<div class="field field-text field-text-lg w-full">
					<label for="query" class="sr-only">Search for topics, publications, and more</label>
					<input type="text" id="query" name="query" value="<?php echo $search_query; ?>" placeholder="Search for topics, publications, and more">
					<button type="button"
						class="
							absolute top-1/2 -translate-y-1/2 right-4 
							text-gray-300 hover:text-gray-500 
							cursor-pointer transition-all
							<?php echo $search_query ? "scale-100 opacity-100" : "scale-0 opacity-0"; ?>
						">
						<?php echo serc_svg("close", "size-6") ?>
					</button>
				</div>
				<button type="submit" class="btn btn-primary btn-lg">Search</button>
			</div>
			<div class="grid grid-cols-1 lg:grid-cols-3">
				<div class="lg:col-span-2">
					<p class="text-sm font-medium text-dark-secondary">Filter by Media Type</p>
					<div class="flex flex-wrap gap-2 mt-4">
						<?php foreach ($filters as $id => $label) : ?>
							<div class="field field-toggle">
								<input type="checkbox" id="filter-<?php echo $id; ?>" name="<?php echo $id; ?>" value="1" class="sr-only">
								<label for="filter-<?php echo $id; ?>" class="label"><?php echo $label; ?></label>
								<?php echo serc_svg('check'); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-span-1 flex flex-col md:flex-row gap-4 lg:gap-10">
					<div class="field field-select field-select-sm w-full gap-y-4">
						<label class="label" for="example">Year</label>
						<select name="example" id="example">
							<?php
							$year = date('Y');
							for ($i = 0; $i < 20; $i++) {
								echo "<option value=\"$year\">$year</option>";
								$year--;
							}
							?>
						</select>
					</div>
					<div class="field field-select field-select-sm w-full gap-y-4">
						<label class="label" for="example">Sort by</label>
						<select name="example" id="example">
							<option value="relevant">Most Relevant</option>
							<option value="relevant">Most Recent</option>
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="container py-14">
		<p class="text-h5 font-normal">Showing 1-10 of 17 results that include <strong><?php echo $search_query; ?></strong></p>
		<div class="field field-checkbox mt-4">
			<input type="checkbox" name="exact" id="exact-checkbox">
			<label class="label" for="exact-checkbox">Show only exact matches for “<?php echo $search_query; ?>”</label>
		</div>
		<div class="mt-10">
			<article class="py-8 border-t border-subtle">
				<h4 class="text-h4 max-w-[var(--breakpoint-lg)] "><a href="#" class="hover:text-brand focus:text-brand outline-0 transition-colors">Trusted Artificial Intelligence Systems Engineering Challenge</a></h4>
				<p class="text-h6 text-light-surface-subtle mt-6 max-w-[var(--breakpoint-lg)] ">By Dr. Peter Beling, Mr. Thomas McDermott, Dr. Stephen Adams</p>
				<p class="body-base mt-4 max-w-[var(--breakpoint-lg)] ">The Trusted AI Challenge for Armaments SE is a novel approach to improving the performance of AI-enabled systems. Rather than focusing on improving AI models, this challenge asks student teams to develop SE methods to build and operate systems that provide trustworthy behaviors using components that are less trustworthy. Over the years, engineers have...</p>
				<p class="uppercase font-light mt-4">Resource Type <span class="mx-2">|</span> MMM DD, YYYY</p>
			</article>
		</div>
	</div>

</main>

<?php get_footer(); ?>