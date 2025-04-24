<?php

use Serc2025\Helpers;

$events = $args['events'] ?? [];
?>

<?php if (empty($events)) : ?>
	<p class="text-h3">No events found</p>
	<p class="body-lg mt-6">Try removing some filters or performing a <a href="<?php echo home_url('/search'); ?>" class="text-brand hover:underline focus:underline outline-0"><strong>search</strong></a>.</p>
<?php else : ?>
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-12">
		<?php foreach ($events as $event) : ?>
			<?php
			$calendar = serc_svg("calendar", "inline-block text-brand size-4 mr-2");
			$pin = serc_svg("location", "inline-block text-brand size-4 mr-1");
			$details = Helpers::get_event_details($event->ID);
			ob_start(); ?>
			<div class="flex flex-col gap-1">
				<span class="flex items-center"><?php echo $calendar . ' ' . $details['schedule']; ?></span>
				<span class="flex items-center"><?php echo $details['location'] ? $pin . ' ' . $details['location'] : ''; ?></span>
			</div>
			<?php $event_details = ob_get_clean(); ?>
			<?php get_template_part('components/card-vert', null, [
				'title' => get_the_title($event->ID),
				'url' => get_the_permalink($event->ID),
				'label_below' => $event_details,
				'text' => get_the_excerpt($event->ID),
				'cta' => 'Read More ' . serc_svg('arrow-right', 'inline text-brand size-5 ml-1 transition-transform group-hover/card:translate-x-2'),
				'image' => get_the_post_thumbnail($event->ID, 'small', ['class' => 'block w-full', 'loading' => 'lazy'])
			]); ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>