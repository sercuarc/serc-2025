<?php

/**
 * Single Event
 */

use Serc2025\Helpers;

$id = get_the_ID();
$image = get_the_post_thumbnail($id, 'medium', ['class' => 'hero-image']);
$bg_image = str_replace('hero-image', 'hero-bg-image', $image);
$isUpcoming = strtotime(get_post_meta($id, '_EventStartDate', true)) > time();
$event_website = tribe_get_event_website_url(get_the_ID());
$venue_name = tribe_get_venue();
$venue_address = tribe_get_full_address();
$venue_phone = tribe_get_phone();
$venue_website = tribe_get_venue_website_url();
$organizer_name = tribe_get_organizer();
$organizer_phone = tribe_get_organizer_phone();
$organizer_website = tribe_get_organizer_website_url();
$organizer_email = tribe_get_organizer_email();
$breadcrumbs = [
	'Events' => home_url('/events')
];
if ($isUpcoming) {
	$breadcrumbs['Upcoming Events'] = home_url('/events/?view=upcoming');
} else {
	$breadcrumbs['Past Events'] = home_url('/events/?view=past');
}

$calendar = serc_svg("calendar", "inline-block size-5 mr-2");
$pin = serc_svg("location", "inline-block size-5 mr-1");
$details = Helpers::get_event_details(get_the_ID());

ob_start(); ?>
<p class="flex flex-col sm:flex-row gap-1 sm:gap-4 mt-3">
	<span class="flex items-center"><?php echo $calendar . ' ' . $details['schedule']; ?></span>
	<span class="flex items-center"><?php echo $details['location'] ? $pin . ' ' . $details['location'] : ''; ?></span>
</p>
<?php if ($isUpcoming) : ?>
	<div class="flex items-center gap-4 mt-4 lg:mt-8">
		<?php if ($event_website) : ?>
			<a href="<?php echo $event_website; ?>" class="btn btn-primary"><?php echo serc_svg("external-link", "size-4"); ?>Register</a>
		<?php endif; ?>
		<a href="<?php echo tribe_get_gcal_link(); ?>" class="btn <?php echo $bg_image ? 'btn-inverted-outline' : 'btn-outline' ?>"><?php echo serc_svg("calendar-add", "size-4"); ?>Add to Calendar</a>
		<!-- <a href="<?php echo tribe_get_single_ical_link(); ?>" class="btn <?php echo $bg_image ? 'btn-inverted-outline' : 'btn-outline' ?>"><?php echo serc_svg("download", "size-4"); ?>Download invite (.ics)</a> -->
	</div>
<?php endif; ?>
<?php $hero_html = ob_get_clean(); ?>

<main>
	<?php get_template_part('components/hero', null, [
		'bg_image' => $bg_image,
		'blur_bg' => true,
		'image' => $image,
		'center_y' => false,
		'title' => get_the_title(),
		'breadcrumbs' => $breadcrumbs,
		'custom_html' => $hero_html
	]); ?>
	<section data-event-bar-threshold class="relative py-12 lg:py-20 overflow-y-hidden">
		<div data-event-bar class="absolute z-40 top-0 left-0 w-full bg-white py-6 shadow-lg -translate-y-full transition-transform duration-300 ease-in-out" aria-hidden="true" tabindex="-1">
			<div class="container flex items-center">
				<div>
					<p class="text-h5"><?php the_title(); ?></p>
					<p class="flex gap-4 mt-1">
						<span class="flex items-center"><?php echo serc_svg("calendar", "inline-block size-4 mr-2 text-brand") . ' ' . $details['schedule']; ?></span>
						<span class="flex items-center"><?php echo $details['location'] ? serc_svg("location", "inline-block size-4 mr-1 text-brand") . ' ' . $details['location'] : ''; ?></span>
					</p>
				</div>
				<?php if ($isUpcoming) : ?>
					<div class="shrink-0 ml-auto flex items-center gap-4">
						<?php if ($event_website) : ?>
							<a href="<?php echo $event_website; ?>" class="btn btn-primary"><?php echo serc_svg("external-link", "size-4"); ?>Register</a>
						<?php endif; ?>
						<a href="<?php echo tribe_get_gcal_link(); ?>" class="btn btn-secondary"><?php echo serc_svg("calendar-add", "size-4"); ?>Add to Calendar</a>
						<!-- <a href="<?php echo tribe_get_single_ical_link(); ?>" class="btn btn-secondary"><?php echo serc_svg("download", "size-4"); ?>Download invite (.ics)</a> -->
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="container grid grid-cols-1 lg:grid-cols-4 gap-9 lg:gap-18 items-start">
			<div class="lg:col-span-3 flex flex-col gap-10 lg:gap-20 order-2 lg:order-1 body-lg">
				<?php the_content(); ?>
			</div>
			<div class="lg:col-span-1 order-1 lg:order-2">
				<h3 class="text-h5">Share</h3>
				<?php get_template_part('components/share', null, [
					'title' => get_the_title(),
					'url' => get_the_permalink()
				]); ?>
			</div>
		</div>
	</section>

	<?php if ($people = get_field("people")) : ?>
		<section class="py-12 lg:py-20 bg-light-secondary">
			<div class="container">
				<?php if ($people_title = get_field("people_title")) : ?>
					<h2 class="text-title-2 mb-16"><?php echo $people_title; ?></h2>
				<?php endif; ?>
				<div class="max-w-[64rem] grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-y-16 lg:gap-x-24">
					<?php foreach ($people as $person) :
						$image = get_the_post_thumbnail($person, 'small', ['class' => 'aspect-square size-[7rem] object-cover']);
						$name = get_the_title($person);
						$job_title = get_field("job_title", $person);
						$url = get_the_permalink($person);
					?>
						<a href="<?php echo $url; ?>" class="group/person flex items-start gap-4">
							<?php echo $image; ?>
							<div class="flex flex-col gap-2">
								<h3 class="text-h5 group-hover/person:text-brand group-focus/person:text-brand"><?php echo $name; ?></h3>
								<p class="text-sm text-light-surface-subtle"><?php echo $job_title; ?></p>
								<p class="font-medium group-hover/person:text-brand group-focus/person:text-brand transition-colors">View Bio <?php echo serc_svg("arrow-right", "text-brand group-hover/person:translate-x-2 transition-transform inline-block size-5 ml-1"); ?></p>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php while (have_rows('event_content_blocks')) : the_row(); ?>

		<?php if (get_row_layout() == 'schedule') : ?>

			<section class="py-12 lg:py-20">
				<div class="container">
					<?php if ($schedule_title = get_sub_field("title")) : ?>
						<h2 class="text-title-2 mb-12"><?php echo $schedule_title; ?></h2>
					<?php endif; ?>
					<?php while (have_rows('schedule_items')) : the_row(); ?>
						<article class="py-8 lg:py-12 border-t border-subtle">
							<?php if ($title = get_sub_field("title")) : ?>
								<h3 class="text-h3 mb-2"><?php echo $title; ?></h3>
							<?php endif; ?>
							<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap:12 xl:gap-24">
								<div class="lg:col-span-2 flex flex-col gap-6">
									<?php
									$start_time = get_sub_field("start_time");
									$end_time = get_sub_field("end_time");
									if ($start_time || $end_time) : ?>
										<p class="font-medium flex items-center">
											<?php echo serc_svg("clock", "inline-block size-5 mr-2 text-brand") ?>
											<?php echo $start_time . ($end_time ? " - " . $end_time : ""); ?>
										</p>
									<?php endif; ?>
									<?php if ($content = get_sub_field("content")) : ?>
										<div class="wysiwyg">
											<?php echo apply_filters('the_content', $content); ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="col-span-1">
									<?php if ($right_column_title = get_sub_field("right_column_title")) : ?>
										<h4 class="text-h5"><?php echo $right_column_title; ?></h4>
									<?php endif; ?>
									<?php if ($right_column_content = get_sub_field("right_column_content")) : ?>
										<div class="wysiwyg wysiwyg-tight mt-5"><?php echo apply_filters('the_content', $right_column_content); ?></div>
									<?php endif; ?>
									</ul>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			</section>

		<?php endif; ?>

	<?php endwhile; ?>

	<section class="py-12 lg:py-20 bg-light-tertiary">
		<div class="container">
			<h3 class="text-title-2">Details</h3>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-20">

				<div class="flex flex-col gap-6 mt-12">
					<h4 class="text-h4 pt-1">Event</h4>
					<p class="text-lg font-medium"><?php the_title(); ?></p>
					<dl>
						<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Start Date</dt>
						<dd class="text-base leading-[28px]"><?php echo tribe_get_start_date(get_the_ID()); ?></dd>
						<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">End Date</dt>
						<dd class="text-base leading-[28px]"><?php echo tribe_get_end_date(get_the_ID()); ?></dd>
						<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Event Link</dt>
						<dd class="text-base leading-[28px] overflow-hidden text-ellipsis"><a href="<?php echo $event_website; ?>" class="text-brand hover:underline focus:underline outline-0 whitespace-nowrap"><?php echo serc_svg("external-link", "inline-block size-4 mr-1 align-[-0.1em]"); ?> <?php echo $event_website; ?></a></dd>
					</dl>
				</div>

				<div class="flex flex-col gap-6 mt-12">
					<h4 class="text-h4 pt-1">Venue</h4>
					<?php if ($venue_name) : ?>
						<p class="text-lg font-medium"><?php echo $venue_name; ?></p>
					<?php endif; ?>
					<dl>
						<?php if ($venue_address) : ?>
							<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Address</dt>
							<dd class="text-base leading-[28px]"><?php echo $venue_address; ?></dd>
						<?php endif; ?>
						<?php if ($venue_phone) : ?>
							<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Phone</dt>
							<dd class="text-base leading-[28px]"><a href="tel:<?php echo $venue_phone; ?>" class="text-brand hover:underline focus:underline outline-0 whitespace-nowrap"><?php echo $venue_phone; ?></a></dd>
						<?php endif; ?>
						<?php if ($venue_website) : ?>
							<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Website</dt>
							<dd class="text-base leading-[28px] overflow-hidden text-ellipsis"><a href="<?php echo $venue_website; ?>" class="text-brand hover:underline focus:underline outline-0 whitespace-nowrap"><?php echo serc_svg("external-link", "inline-block size-4 mr-1 align-[-0.1em]"); ?> <?php echo $venue_website; ?></a></dd>
						<?php endif; ?>
					</dl>
				</div>

				<div class="flex flex-col gap-6 mt-12">
					<h4 class="text-h4 pt-1">Organizer</h4>
					<?php if ($organizer_name) : ?>
						<p class="text-lg font-medium"><?php echo $organizer_name; ?></p>
					<?php endif; ?>
					<dl>
						<?php if ($organizer_phone) : ?>
							<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Phone</dt>
							<dd class="text-base leading-[28px]"><a href="tel:<?php echo $organizer_phone; ?>" class="text-brand hover:underline focus:underline outline-0 whitespace-nowrap"><?php echo $organizer_phone; ?></a></dd>
						<?php endif; ?>
						<?php if ($organizer_email) : ?>
							<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Email</dt>
							<dd class="text-base leading-[28px]"><a href="mailto:<?php echo $organizer_email; ?>" class="text-brand hover:underline focus:underline outline-0 whitespace-nowrap"><?php echo $organizer_email; ?></a></dd>
						<?php endif; ?>
						<?php if ($organizer_website) : ?>
							<dt class="not-first:mt-5 font-bold text-light-surface-subtle leading-5">Website</dt>
							<dd class="text-base leading-[28px] overflow-hidden text-ellipsis"><a href="<?php echo $organizer_website; ?>" class="text-brand hover:underline focus:underline outline-0 whitespace-nowrap"><?php echo serc_svg("external-link", "inline-block size-4 mr-1 align-[-0.1em]"); ?> <?php echo $organizer_website; ?></a></dd>
						<?php endif; ?>
					</dl>
				</div>

			</div>
		</div>
	</section>
</main>

<script type="text/javascript" defer>
	window.addEventListener('DOMContentLoaded', function() {
		const minScreenWidth = 1024;
		// dont run on small screens
		if (window.innerWidth < minScreenWidth) return;
		// get elements
		const eventBar = document.querySelector('[data-event-bar]');
		const eventBarThreshold = document.querySelector('[data-event-bar-threshold]');
		if (!eventBar || !eventBarThreshold) return;
		const navigation = document.querySelector('[data-navigation]') || {
			offsetHeight: 0
		};
		// calculate thresholds and sizes
		function getMeasurements() {
			const threshold = eventBarThreshold.offsetTop;
			const fixedOffset = navigation.offsetHeight;
			return {
				threshold,
				fixedOffset
			};
		}
		let m = getMeasurements();
		// manage the fixed state
		let fixed = false;
		// on scroll...
		window.addEventListener('scroll', () => {
			console.log(window.scrollY, m.threshold, m.fixedOffset);

			if (window.innerWidth < minScreenWidth) return;
			if (window.scrollY > m.threshold - m.fixedOffset) {
				if (!fixed) {
					eventBar.classList.remove('-translate-y-full', 'absolute');
					eventBar.classList.add('translate-y-0', 'fixed');
					eventBar.style.top = `${m.fixedOffset}px`;
					fixed = true;
				}
			} else {
				if (fixed) {
					eventBar.classList.add('-translate-y-full', 'absolute');
					eventBar.classList.remove('translate-y-0', 'fixed');
					eventBar.style.top = '';
					fixed = false;
				}
			}
		});
		// on resize...
		window.addEventListener('resize', () => {
			if (window.innerWidth >= minScreenWidth) {
				m = getMeasurements();
			}
		});
	});
</script>