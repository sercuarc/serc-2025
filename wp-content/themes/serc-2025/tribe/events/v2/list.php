<?php

/**
 * Default Events List View
 */

$eventsUrl = tribe_events_get_url([
	'view' => 'upcoming'
]);
$eventsPastUrl = tribe_events_get_url([
	'view' => 'past'
]);
$view = 'upcoming';
if (isset($_GET['view']) && $_GET['view'] == 'past') {
	$view = 'past';
}
$selected_year = isset($_GET['events-year']) ? $_GET['events-year'] : null;
?>


<main>
	<?php get_template_part('components/hero', null, [
		'title' => 'Events',
		'title_class' => 'text-h1',
		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris laoreet hendrerit leo ac aliquam. Sed pellentesque nibh nibh.',
		'description_class' => 'body-lg mt-7',
		'center_y' => true
	]); ?>
	<div class="container py-12 lg:py-20">
		<div class="flex sm:items-end flex-col sm:flex-row gap-4 sm:gap-8 lg:gap-24 pb-12 lg:pb-20">
			<nav class="tab-menu">
				<a href="<?php echo $eventsUrl; ?>" class="tab <?php echo $view === 'upcoming' ? "is-active" : "" ?>">Upcoming Events</a>
				<a href="<?php echo $eventsPastUrl; ?>" class="tab <?php echo $view === 'past' ? "is-active" : "" ?>">Past Events</a>
			</nav>
			<?php if ($view === 'past') : ?>
				<?php
				$years = [];
				$current_year = (int) date('Y');
				for ($year = $current_year; $year >= 2008; $year--) {
					$years[] = $year;
				}
				?>
				<div class="field field-select field-select-md min-w-[200px]">
					<label class="label" for="example">Filter by Year</label>
					<select onchange="window.location.href=window.location.origin + window.location.pathname + '?view=<?php echo $view; ?>&events-year=' + this.value">
						<?php foreach ($years as $year) : ?>
							<option value="<?php echo $year; ?>" <?php if ($year == $selected_year) echo 'selected'; ?>><?php echo $year; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>
		</div>
		<?php
		if ($view === 'past') {
			get_template_part('components/events-grid');
		} else {
			get_template_part('components/events-list');
		} ?>
	</div>
</main>