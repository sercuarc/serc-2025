<?php

/**
 * ------------------------- *
 *  Default Events Template  *
 * ------------------------- *
 */

if (! is_singular()) {

	// Redirect to the Events Landing page
	// Make sure to set the 'Events URL Slug', in the Events Calendar settings, to something OTHER than "events" (e.g. "events-archive").

	$redirect_to = home_url('events');
	header("Location: $redirect_to", true, 301);
	die();

	// We are redirecting to a page because we need more control over the events list landing page. 
	// The user behavior we want goes against the grain of the way TEC wants to do things.
	// Specifically, when it comes to filtering past events by year, it was a struggle to get TEC to display the events we wanted.
	// Ultimately, the easiest solution was to create custom page template and query events manually.

	// Also, we wanted admins to be able to customize the page title and hero image.
	// We prefer to allow them that control via a page in the CMS vs. custom fields in the events settings or somewhere else.

}

// use Tribe\Events\Views\V2\Template_Bootstrap;

get_header();

// echo tribe(Template_Bootstrap::class)->get_view_html();
tribe_get_template_part('single-event');

get_footer();
