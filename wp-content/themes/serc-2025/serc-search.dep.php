<?php

/**
 * Template Name: SERC Search
 */

?>

<?php get_header(); ?>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
	document.addEventListener('alpine:init', () => {

		Alpine.data('searchApp', (initialQuery = "") => ({
			status: "idle",
			query: initialQuery,
			sort: "relevance",
			year: "all",
			resultsQuery: "",
			results: null,

			init() {
				console.log('Search App initialized');
			},

			truncate(str) {
				const words = str.split(' ');
				return words.slice(0, 30).join(' ') + (words.length > 10 ? ' ...' : '');
			},

			formatDate(dateString) {
				const d = new Date(dateString);
				return d.toLocaleDateString('en-US', {
					year: 'numeric',
					month: 'long',
					day: 'numeric'
				});
			},

			handleSortChange(e) {
				if (this.query.length > 0) {
					this.handleSubmit(null, this.$refs.form)
				}
			},

			async handleSubmit(e, form) {
				this.status = "loading";
				const formData = new FormData(form || e.target);

				const params = new URLSearchParams(formData);
				const queryString = params.toString();

				const res = await fetch('/wp-json/serc-2025/v1/search?' + queryString);
				const json = await res.json()

				this.resultsQuery = formData.get('query');
				this.results = json;
				this.status = "idle";
			}
		}))

	});
</script>

<div x-data="searchApp('<?php echo get_query_var('query'); ?>')" class="flex flex-col gap-8">

	<form x-ref="form" data-search-form method="get" action="/search" x-on:submit.prevent="handleSubmit" class="flex flex-col gap-8">

		<div class="relative flex flex-wrap items-center gap-8 bg-gray-100 p-4 rounded-lg">
			<div data-search-field class="w-full max-w-96 relative bg-white border border-gray-500 rounded-lg overflow-hidden">
				<label for="query" class="sr-only">Search topics, publications, and more</label>
				<input type="text" x-model="query" id="query" name="query" placeholder="Search topics, publications, and more" class="block p-4 text-lg w-full h-full" />
				<button class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg p-2 hover:bg-gray-300 cursor-pointer" type="submit" aria-label="Search">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						</g>
					</svg>
				</button>
			</div>
			<!-- Data field -->
			<div data-filter-date class="flex items-center gap-4 w-full max-w-72">
				<strong class="whitespace-nowrap">Year</strong>
				<select name="year" x-model="year" class="w-full bg-white border border-gray-500 rounded-lg block p-4 text-lg">
					<option value="all">All</option>
					<?php
					// make list of year options going back 20 years
					$year = date('Y');
					for ($i = $year; $i >= $year - 20; $i--) {
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
					?>
				</select>
			</div>
			<!-- Sorting Field -->
			<div data-sort class="flex items-center gap-4 w-full max-w-72">
				<strong class="whitespace-nowrap">Sort By</strong>
				<select name="sort" x-model="sort" class="w-full bg-white border border-gray-500 rounded-lg block p-4 text-lg"
					@change.prevent="handleSortChange">
					<option value="relevance">Most relevant</option>
					<option value="date">Date</option>
					<option value="title">Title</option>
				</select>
			</div>
			<!-- Content Type Filters -->
			<div data-filter-content-type class="lg:absolute top-full mt-8 col-span-2 flex flex-col gap-4">
				<p class="text-xl font-bold">Filter by Content Type:</p>
				<ul class="flex flex-col gap-2">
					<li>
						<input type="checkbox" id="content_type_events_news" name="content_type[]" value="events_news">
						<label for="content_type_events_news">Events/News</label>
					</li>
					<li>
						<input type="checkbox" id="content_type_media" name="content_type[]" value="media">
						<label for="content_type_media">Media</label>
					</li>
					<li>
						<input type="checkbox" id="content_type_people" name="content_type[]" value="people">
						<label for="content_type_people">People</label>
					</li>
					<li>
						<input type="checkbox" id="content_type_publications" name="content_type[]" value="publications">
						<label for="content_type_publications">Publications</label>
					</li>
					<li>
						<input type="checkbox" id="content_type_resources" name="content_type[]" value="resources">
						<label for="content_type_resources">Resources</label>
					</li>
				</ul>
			</div>
		</div>

	</form>

	<div class="grid grid-cols-12 gap-12">

		<h2 class="text-3xl col-span-12 lg:col-span-9 lg:col-start-4">
			<template x-if="status === 'loading'">
				<span class="text-red-700">Searching...</span>
			</template>
			<template x-if="status === 'idle' && resultsQuery && results?.hits?.length">
				<span>Found <strong x-text="results.estimatedTotalHits"></strong> results for: "<strong x-text="resultsQuery"></strong>"</span>
			</template>
			<template x-if="status === 'idle' && !results?.hits?.length">
				<span>No Results</span>
			</template>
		</h2>

		<template x-if="results?.hits?.length">
			<template x-for="hit in results.hits">
				<article class="flex flex-col gap-4 rounded-lg col-span-12 lg:col-span-9 xl:col-span-6 lg:col-start-4 xl:col-start-4">
					<p class="text-sm font-bold flex gap-4">
						<span class="opacity-50" x-text="hit.type"></span>
						<span x-text="formatDate(hit.publication_date)"></span>
					</p>
					<h2 class="text-xl" x-text="hit.title"></h2>
					<p x-text="truncate(hit.abstract)" class="text-base leading-relaxed"></p>
					<p><a x-bind:href="hit.file_s3" class="font-bold text-xl">Read More ></a></p>
				</article>
			</template>
		</template>


	</div>
</div>

<?php get_footer(); ?>