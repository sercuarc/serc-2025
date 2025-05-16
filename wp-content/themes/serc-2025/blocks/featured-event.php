<?php

use Serc2025\Helpers;

$title = get_field('featured_event_title') ?: 'Upcoming Event';
$event_id = get_field('featured_event_event');
$button = get_field('featured_event_button') ?: (is_admin() ? ['title' => 'Add a Button (optional)', 'url' => '#', 'target' => '_self'] : null);
?>

<div class="py-16 lg:py-30">
	<div class="container flex flex-col gap-10 lg:gap-16">
		<?php if ($title) : ?>
			<h2 class="text-title-1 text-center">
				<?php echo $title; ?>
			</h2>
		<?php endif; ?>
		<?php if ($event_id) : $event = get_post($event_id); ?>
			<div class="bg-light-secondary px-8 lg:px-14 py-12 lg:py-20 border-t-4 border-brand">
				<?php
				$calendar = serc_svg("calendar", "inline-block text-brand size-5 mr-2");
				$pin = serc_svg("location", "inline-block text-brand size-5 mr-1");
				$details = Helpers::get_event_details($event_id);
				ob_start(); ?>
				<div class="flex flex-col sm:flex-row gap-1 sm:gap-4">
					<span class="flex items-center"><?php echo $calendar . ' ' . $details['schedule']; ?></span>
					<span class="flex items-center"><?php echo $details['location'] ? $pin . ' ' . $details['location'] : ''; ?></span>
				</div>
				<?php $event_details = ob_get_clean();
				get_template_part('components/card-horz-alt', null, [
					'title' => get_the_title($event),
					'label_below' => $event_details,
					'text' => get_the_excerpt($event),
					'url' => get_the_permalink($event),
					'order' => 'image-left',
					'reversed' => true,
					'cta' => ['text' => 'View Event Details', 'url' => get_the_permalink($event), 'style' => 'link'],
					'image' => get_the_post_thumbnail($event, 'medium', [
						'class' => 'w-full p-3 lg:p-6 border border-normal',
						'loading' => 'lazy'
					])
				]); ?>
			</div>
		<?php endif; ?>
		<?php if ($button) : ?>
			<div class="text-center">
				<a href="<?php echo esc_url($button['url']); ?>" class="btn btn-primary" target="<?php echo esc_attr($button['target']); ?>" rel="noopener noreferrer">
					<?php echo esc_html($button['title']); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>