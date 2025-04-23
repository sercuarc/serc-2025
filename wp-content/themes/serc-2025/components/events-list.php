<?php

use Serc2025\Helpers;

$count = 0;
while (have_posts()) : the_post(); ?>

	<?php if ($count > 0) : ?>
		<hr class="border-subtle my-12 lg:my-24" />
	<?php endif;
	$count++; ?>

	<?php
	$calendar = serc_svg("calendar", "inline-block text-brand size-4 mr-2");
	$isAllDay = get_post_meta($post, '_EventAllDay', true);
	$start_date = get_post_meta($post, '_EventStartDate', true);
	$end_date = get_post_meta($post, '_EventEndDate', true);
	$schedule = Helpers::formatEventDates($start_date, $end_date, $isAllDay);

	$city = tribe_get_city();
	$state = tribe_get_stateprovince();
	$country = tribe_get_country();
	$pin = serc_svg("location", "inline-block text-brand size-4 mr-1");
	$location = implode(', ', array_filter([$city, $state, $country]));

	ob_start(); ?>
	<div class="flex flex-col sm:flex-row gap-1 sm:gap-4">
		<span class="flex items-center"><?php echo $calendar . ' ' . $schedule; ?></span>
		<span class="flex items-center"><?php echo $location ? $pin . ' ' . $location : ''; ?></span>
	</div>
	<?php $event_details = ob_get_clean(); ?>

	<?php get_template_part('components/card-horz', null, [
		'title' => get_the_title(),
		'label_below' => $event_details,
		'text' => get_the_excerpt(),
		'cta' => ['text' => 'View Event Details', 'url' => get_the_permalink()],
		'image' => get_the_post_thumbnail($post, 'medium', array('class' => 'w-full p-3 lg:p-6 border border-normal'))
	]); ?>

<?php endwhile; ?>