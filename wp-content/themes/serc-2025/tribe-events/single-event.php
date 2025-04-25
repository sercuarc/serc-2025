<?php

/**
 * Single Event
 */

use Serc2025\Helpers;

$id = get_the_ID();
$image = get_the_post_thumbnail($id, 'full', array('class' => 'blur-sm'));
$isUpcoming = strtotime(get_post_meta($id, '_EventStartDate', true)) > time();
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
?>

<main>
	<header class="hero <?php if ($image) : ?>hero--inverted hero--with-image<?php endif; ?>">
		<?php
		if ($image) {
			echo $image;
		}
		?>
		<div class="container">
			<?php get_template_part('components/breadcrumbs', '', [
				'breadcrumbs' => $breadcrumbs
			]); ?>
		</div>
		<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-center">
			<div class="lg:col-span-2 order-2 lg:order-1">
				<h1 class="text-h2"><?php the_title(); ?></h1>
				<p class="flex flex-col sm:flex-row gap-1 sm:gap-4 mt-7">
					<span class="flex items-center"><?php echo $calendar . ' ' . $details['schedule']; ?></span>
					<span class="flex items-center"><?php echo $details['location'] ? $pin . ' ' . $details['location'] : ''; ?></span>
				</p>
			</div>
			<div class="order-1 lg:order-2">
				<?php the_post_thumbnail('medium', array('class' => 'border border-subtle block w-full md:w-auto')); ?>
			</div>
		</div>
	</header>
	<section class="py-12 lg:py-20">
		<div class="container grid grid-cols-1 lg:grid-cols-4 gap-9 lg:gap-18 items-start">
			<div class="lg:col-span-3 flex flex-col gap-10 lg:gap-20 order-2 lg:order-1">
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
	<section class="py-12 lg:py-20 bg-light-tertiary">
		<div class="container">
			<h3 class="text-title-2">Details</h3>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-20">

				<div class="flex flex-col gap-6 mt-12">
					<h4 class="text-h4 pt-1">Event</h4>
					<p class="text-lg font-medium"><?php the_title(); ?></p>
					<dl>
						<?php
						$event_website = tribe_get_event_website_url(get_the_ID());
						?>
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
					<?php
					$venue_name = tribe_get_venue();
					$venue_address = tribe_get_full_address();
					$venue_phone = tribe_get_phone();
					$venue_website = tribe_get_venue_website_url();
					?>
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
					<?php
					$organizer_name = tribe_get_organizer();
					$organizer_phone = tribe_get_organizer_phone();
					$organizer_website = tribe_get_organizer_website_url();
					$organizer_email = tribe_get_organizer_email();
					?>
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