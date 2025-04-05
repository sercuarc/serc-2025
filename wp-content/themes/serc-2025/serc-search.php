<?php

/**
 * SERC Search
 */

?>

<?php get_header(); ?>
<?php $filters = [
	'events-news' => "Events / News",
	'media' => "Media",
	'people' => "People",
	'publications' => "Publications",
]; ?>

<main>

	<script type="text/javascript">
		const SEARCH_APP = {
			searchQuery: "<?php echo get_query_var('query'); ?>",
			filters: <?php echo json_encode($filters); ?>
		};
	</script>
	<div id="app-search">

		<div class="hero bg-light-tertiary py-20">
			<form class="container flex flex-col gap-6" @submit.prevent="handleSearch">
				<h1 class="text-title-1">Search{{ (results.length ? " Results" : "") }}</h1>
				<div class="flex gap-2 mt-4">
					<div class="field field-text field-text-lg w-full">
						<label for="query" class="sr-only">Search for topics, publications, and more</label>
						<input type="text" id="query" name="query" v-model="searchQuery" placeholder="Search for topics, publications, and more">
						<button type="button"
							:class="{ 'scale-100 opacity-100': searchQuery.length > 0, 'scale-0 opacity-0': searchQuery.length === 0 }"
							class="
								absolute top-1/2 -translate-y-1/2 right-4 
								text-gray-300 hover:text-gray-500 
								cursor-pointer transition-all
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
							<div v-for="label, id in filters" :key="id" class="field field-toggle">
								<input type="checkbox" :id="'filter-' + id" name="filters[]" :value="id" class="sr-only">
								<label :for="'filter-' + id" class="label">{{ label }}</label>
								<?php echo serc_svg('check'); ?>
							</div>
						</div>
					</div>
					<div class="col-span-1 flex flex-col md:flex-row gap-4 lg:gap-10">
						<div class="field field-select field-select-sm w-full gap-y-4">
							<label class="label" for="year">Year</label>
							<select name="year" id="year">
								<option v-for="year in recentYears" :key="year" :value="year">{{ year }}</option>
							</select>
						</div>
						<div class="field field-select field-select-sm w-full gap-y-4">
							<label class="label" for="sort">Sort by</label>
							<select name="sort" id="sort">
								<option value="relevant">Most Relevant</option>
								<option value="recent">Most Recent</option>
							</select>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="container py-14">
			<div v-if="status === 'loading'" class="flex items-center justify-center" style="min-height: 10rem">
				<?php echo serc_svg("serc-star", "size-16 text-brand animate-spin"); ?>
			</div>
			<p v-if="results.length" class="text-h5 font-normal">Showing 1-10 of 17 results that include <strong>{{ searchQuery }}</strong></p>
			<div v-if="results.length" class="field field-checkbox mt-4">
				<input type="checkbox" name="exact" id="exact-checkbox">
				<label class="label" for="exact-checkbox">Show only exact matches for “{{ searchQuery }}”</label>
			</div>
			<div v-if="results.length" class="mt-10">
				<article
					class="
						relative hover:z-10 py-8 flex flex-col gap-4 border-t border-subtle
						before:absolute beore:z-[-1] before:top-0 before:-left-6 before:-right-6 before:-bottom-0 before:bg-light-main before:transition-shadow hover:before:shadow-[0_4px_12px_0_rgba(0,0,0,0.15)]
					">
					<h4 class="relative text-h4 max-w-[var(--breakpoint-lg)] mb-2"><a href="#" class="hover:text-brand focus:text-brand outline-0 transition-colors">Trusted Artificial Intelligence Systems Engineering Challenge</a></h4>
					<p class="relative text-h6 text-light-surface-subtle max-w-[var(--breakpoint-lg)] ">By Dr. Peter Beling, Mr. Thomas McDermott, Dr. Stephen Adams</p>
					<p class="relative body-base max-w-[var(--breakpoint-lg)] ">The Trusted AI Challenge for Armaments SE is a novel approach to improving the performance of AI-enabled systems. Rather than focusing on improving AI models, this challenge asks student teams to develop SE methods to build and operate systems that provide trustworthy behaviors using components that are less trustworthy. Over the years, engineers have...</p>
					<p class="relative uppercase font-light">Resource Type <span class="mx-2">|</span> MMM DD, YYYY</p>
				</article>
			</div>
		</div>

	</div>

</main>

<!-- <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script> -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script type="module" src="<?php echo get_template_directory_uri() . "/assets/dist/js/app.search.js"; ?>"></script>
<?php get_footer(); ?>