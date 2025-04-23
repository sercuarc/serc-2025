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
		<nav class="tab-menu pb-12 lg:pb-20">
			<a href="<?php echo $eventsUrl; ?>" class="tab <?php echo $view === 'upcoming' ? "is-active" : "" ?>">Upcoming Events</a>
			<a href="<?php echo $eventsPastUrl; ?>" class="tab <?php echo $view === 'past' ? "is-active" : "" ?>">Past Events</a>
		</nav>
		<?php
		if ($view === 'past') {
			get_template_part('components/events-grid');
		} else {
			get_template_part('components/events-list');
		} ?>
	</div>
</main>