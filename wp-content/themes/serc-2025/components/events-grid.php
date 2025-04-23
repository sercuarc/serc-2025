<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
	<?php while (have_posts()) : the_post(); ?>
		<?php get_template_part('components/event-card', null, [
			'title' => get_the_title(),
			'date' => tribe_events_event_schedule_details()
		]); ?>
	<?php endwhile; ?>
</div>