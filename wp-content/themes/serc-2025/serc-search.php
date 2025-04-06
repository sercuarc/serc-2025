<?php

/**
 * SERC Search
 */

?>

<?php get_header(); ?>
<?php $doc_types = [
	'events-news' => "Events / News",
	'media' => "Media",
	'people' => "People",
	'publications' => "Publications",
]; ?>

<main>

	<script type="text/javascript">
		const SEARCH_APP = {
			query: "<?php echo get_query_var('query'); ?>",
		};
	</script>
	<div id="app-search">

		<div class="hero bg-light-tertiary py-20">
			<form class="container flex flex-col gap-6" @submit.prevent="handleSearch">
				<h1 class="text-title-1">Search{{ (docs.length ? " Results" : "") }}</h1>
				<div class="flex gap-2 mt-4">
					<div class="field field-text field-text-lg w-full">
						<label for="query" class="sr-only">Search for topics, publications, and more</label>
						<input ref="queryInput" type="text" id="query" name="query" v-model="query" placeholder="Search for topics, publications, and more">
						<button type="button" @click.prevent="resetQuery"
							:class="{ 'scale-100 opacity-100': query.length > 0, 'scale-0 opacity-0': query.length === 0 }"
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
							<?php foreach ($doc_types as $id => $label) : ?>
								<div class="field field-toggle">
									<input type="checkbox"
										:checked="doc_types.includes('<?php echo $id; ?>')"
										@change="toggleDocType('<?php echo $id; ?>')"
										id="<?php echo "filter-$id"; ?>" name="doc_types[]" value="<?php echo $id; ?>" class="sr-only">
									<label for="<?php echo "filter-$id"; ?>" class="label"><?php echo $label; ?></label>
									<?php echo serc_svg('check'); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="col-span-1 flex flex-col md:flex-row gap-4 lg:gap-10">
						<div class="field field-select field-select-sm w-full gap-y-4">
							<label class="label" for="year">Year</label>
							<select v-model="year" name="year" id="year">
								<option value="all">All</option>
								<option v-for="year in recentYears" :key="year" :value="year">{{ year }}</option>
							</select>
						</div>
						<div class="field field-select field-select-sm w-full gap-y-4">
							<label class="label" for="sort">Sort by</label>
							<select v-model="sort" name="sort" id="sort">
								<option value="_score">Most Relevant</option>
								<option value="sortable_date">Most Recent</option>
							</select>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div ref="resultsContainer" class="container py-14">

			<div v-if="status === 'loading'" class="flex items-center justify-center" style="min-height: 10rem">
				<?php echo serc_svg("serc-star", "size-16 text-brand animate-spin"); ?>
			</div>
			<p v-if="status !== 'loading' && docs.length" class="text-h5 font-normal">Showing {{docsOffsetStart}}-{{docsOffsetEnd}} of {{ totalDocs }} results that include <strong>{{ docsQuery }}</strong></p>
			<div v-if="status !== 'loading' && docs.length" class="field field-checkbox mt-4">
				<input v-model="exact" type="checkbox" name="exact" id="exact-checkbox">
				<label class="label" for="exact-checkbox">Show only exact matches for “{{ docsQuery }}”</label>
			</div>
			<div v-if="status !== 'loading' && docs.length" class="mt-10">
				<article
					v-for="doc in docs"
					:key="doc.os_id"
					class="
						relative hover:z-10 py-8 flex flex-col gap-4 border-t border-subtle
						before:absolute beore:z-[-1] before:top-0 before:-left-6 before:-right-6 before:-bottom-0 before:bg-light-main before:transition-shadow hover:before:shadow-[0_4px_12px_0_rgba(0,0,0,0.15)]
					">
					<h4 class="relative text-h4 max-w-[var(--breakpoint-lg)] mb-2"><a href="#" class="hover:text-brand focus:text-brand outline-0 transition-colors">{{doc.title}}</a></h4>
					<p class="relative text-h6 text-light-surface-subtle max-w-[var(--breakpoint-lg)] ">[Authors]</p>
					<div class="relative body-base max-w-[var(--breakpoint-lg)] ">{{truncate(doc.abstract || doc.description || doc.content)}}</div>
					<p class="relative uppercase font-light">{{doc.type}} <span class="mx-2">|</span> {{ formatDate(doc.sortable_date) }}</p>
				</article>
			</div>
			<div v-if="status !== 'loading' && pages.total > 1" class="my-10 flex items-center justify-center gap-7 text-lg font-medium">
				<a href="#" @click.prevent="setPage(1)"
					:class="{ 'grayscale-100 opacity-50 pointer-events-none': pages.current < 2 }"
					class="flex items-center gap-3 hover:text-brand">
					<svg width="16" height="17" viewBox="0 0 16 17" fill="none" class="text-brand" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.9393 1.4043L7.88153 8.4621L14.9393 15.5199" stroke="currentColor" stroke-width="1.76445" />
						<path d="M9.05774 1.4043L1.99994 8.4621L9.05774 15.5199" stroke="currentColor" stroke-width="1.76445" />
					</svg>
					First
				</a>
				<a href="#" @click.prevent="setPage(pages.current - 1)"
					:class="{ 'grayscale-100 opacity-50 pointer-events-none': pages.current < 2 }"
					class="flex items-center gap-3 hover:text-brand">
					<svg width="10" height="17" viewBox="0 0 10 17" fill="none" class="text-brand" xmlns="http://www.w3.org/2000/svg">
						<path d="M8.51453 1.4043L1.45672 8.4621L8.51453 15.5199" stroke="currentColor" stroke-width="1.76445" />
					</svg>
					Previous
				</a>
				<span class="flex items-center gap-3">
					<span v-if="pagingLinks[0] > 1" class="flex items-center justify-center size-9 text-2xl text-dark-main/50">...</span>
					<a v-for="p in pagingLinks" :key="p" :href="`?page=${p}`" @click.prevent="setPage(p)"
						:class="{ 'bg-brand text-white hover:bg-brand hover:text-white' : p === pages.current }"
						class="flex items-center justify-center size-9 text-2xl text-dark-main/50 hover:text-brand">
						{{ p }}
					</a>
					<span v-if="pages.total > pagingLinks[pagingLinks.length - 1]" class="flex items-center justify-center size-9 text-2xl text-dark-main/50">...</span>
				</span>
				<a href="#" @click.prevent="setPage(pages.current + 1)"
					:class="{ 'grayscale-100 opacity-50 pointer-events-none': pages.current == pages.total }"
					class="flex items-center gap-3 hover:text-brand">
					Next
					<svg width="10" height="17" viewBox="0 0 10 17" fill="none" class="text-brand" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.49133 1.4043L8.54914 8.4621L1.49133 15.5199" stroke="currentColor" stroke-width="1.76445" />
					</svg>
				</a>
				<a href="#" @click.prevent="setPage(pages.total)"
					:class="{ 'grayscale-100 opacity-50 pointer-events-none': pages.current == pages.total }"
					class="flex items-center gap-3 hover:text-brand">
					Last
					<svg width="16" height="17" viewBox="0 0 16 17" fill="none" class="text-brand" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.2428 1.4043L8.3006 8.4621L1.2428 15.5199" stroke="currentColor" stroke-width="1.76445" />
						<path d="M7.12445 1.4043L14.1823 8.4621L7.12445 15.5199" stroke="currentColor" stroke-width="1.76445" />
					</svg>
				</a>
			</div>
		</div>

	</div>

</main>

<!-- <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script> -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script type="module" src="<?php echo get_template_directory_uri() . "/assets/dist/js/app.search.js"; ?>"></script>
<?php get_footer(); ?>