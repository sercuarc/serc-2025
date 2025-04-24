<?php

use Serc2025\Helpers;

$events = $args['events'] ?? [];
$count = 0;
?>

<div class="flex flex-col gap-12 lg:gap-24">

	<?php foreach ($events as $event) : ?>

		<?php if ($count > 0) : ?>
			<hr class="border-subtle" />
		<?php endif; ?>

		<?php
		$calendar = serc_svg("calendar", "inline-block text-brand size-4 mr-2");
		$pin = serc_svg("location", "inline-block text-brand size-4 mr-1");
		$details = Helpers::get_event_details($event->ID);
		ob_start(); ?>
		<div class="flex flex-col sm:flex-row gap-1 sm:gap-4">
			<span class="flex items-center"><?php echo $calendar . ' ' . $details['schedule']; ?></span>
			<span class="flex items-center"><?php echo $details['location'] ? $pin . ' ' . $details['location'] : ''; ?></span>
		</div>
		<?php $event_details = ob_get_clean(); ?>

		<?php get_template_part('components/card-horz', null, [
			'title' => get_the_title($event),
			'label_below' => $event_details,
			'text' => get_the_excerpt($event),
			'cta' => ['text' => 'View Event Details', 'url' => get_the_permalink($event)],
			'image' => get_the_post_thumbnail($event, 'medium', [
				'class' => 'w-full p-3 lg:p-6 border border-normal',
				'loading' => 'lazy'
			])
		]); ?>

		<?php $count++; ?>

	<?php endforeach; ?>

</div>