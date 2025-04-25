<?php

/**
 * Template Name: Events Landing
 */

get_header();

// URLs
$eventsUrl = add_query_arg([
	'events-view' => 'upcoming'
], get_the_permalink());
$eventsPastUrl = add_query_arg([
	'events-view' => 'past'
], get_the_permalink());

// View
$view = $_GET['events-view'] ?? 'upcoming';

// Year
$events_year = isset($_GET['events-year']) ? intval($_GET['events-year']) : null;

// Build Meta Query
$now = current_time('Y-m-d H:i:s');
$meta_query = [];
if ($view === 'past') {
	$this_year = date('Y');
	if ($events_year) {
		$start_date = "$events_year-01-01 00:00:00";
		$end_date = $events_year == $this_year ? $now : "$events_year-12-31 23:59:59";
	} else {
		$start_date = "$this_year-01-01 00:00:00";
		$end_date = $now;
	}
	$meta_query[] = [
		'key'     => '_EventStartDate',
		'value'   => [$start_date, $end_date],
		'compare' => 'BETWEEN',
		'type'    => 'DATETIME',
	];
} else {
	// Default to upcoming
	$meta_query[] = [
		'key'     => '_EventStartDate',
		'value'   => $now,
		'compare' => '>=',
		'type'    => 'DATETIME',
	];
}

// Query Events
$events = get_posts([
	'post_type'      => 'tribe_events',
	'posts_per_page' => -1,
	'orderby'        => 'meta_value',
	'meta_key'       => '_EventStartDate',
	'order'          => ($view === 'past') ? 'DESC' : 'ASC',
	'meta_query'     => $meta_query,
	'suppress_filters' => false, // Ensures TEC filters run
]);
?>

<main>
	<?php get_template_part('components/hero', null, [
		'bg_image' => get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'hero-bg-image object-center']),
		'title' => get_the_title(),
		'title_class' => 'text-h1',
		'description' => get_the_content(),
		'description_class' => 'body-lg mt-7',
		'center_y' => true
	]); ?>
	<div class="container py-12 lg:py-16">
		<div class="flex sm:items-end flex-col sm:flex-row gap-4 sm:gap-8 lg:gap-24 <?php echo $view === 'past' ? 'pb-8 lg:pb-12' : 'pb-16 lg:pb-24' ?>">
			<nav class="tab-menu lg:pt-3">
				<a href="<?php echo $eventsUrl; ?>" class="tab <?php echo $view === 'upcoming' ? "is-active" : "" ?>">Upcoming Events</a>
				<a href="<?php echo $eventsPastUrl; ?>" class="tab <?php echo $view === 'past' ? "is-active" : "" ?>">Past Events</a>
			</nav>
			<?php if ($view === 'past') : ?>
				<?php
				$years = [];
				$current_year = intval(date('Y'));
				for ($y = $current_year; $y >= 2015; $y--) {
					$years[] = $y;
				}
				?>
				<div class="field field-select field-select-md min-w-[200px]">
					<label class="label" for="example">Filter by Year</label>
					<select onchange="window.location.href=window.location.origin + window.location.pathname + '?events-view=<?php echo $view; ?>&events-year=' + this.value">
						<?php foreach ($years as $year) : ?>
							<option value="<?php echo $year; ?>" <?php if ($year == $events_year) echo 'selected'; ?>><?php echo $year; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>
		</div>
		<?php if ($view === 'past') : ?>
			<div class="pb-8 lg:pb-12">
				<p class="text-lg text-light-surface-normal">Showing results for the year <strong><?php echo $events_year ?? date('Y'); ?></strong></p>
			</div>
		<?php endif; ?>
		<?php
		if ($view === 'past') {
			get_template_part('components/events-grid', null, [
				'events' => $events
			]);
		} else {
			get_template_part('components/events-list', null, [
				'events' => $events
			]);
		} ?>
	</div>
</main>

<?php get_footer(); ?>