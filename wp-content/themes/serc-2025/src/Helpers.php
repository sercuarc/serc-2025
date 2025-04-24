<?php

/**
 * SERC Theme Helpers
 */

namespace Serc2025;

use DateTime;

class Helpers
{
	public static function get_event_details($post_id)
	{
		$isAllDay = get_post_meta($post_id, '_EventAllDay', true);
		$start_date = get_post_meta($post_id, '_EventStartDate', true);
		$end_date = get_post_meta($post_id, '_EventEndDate', true);
		$schedule = self::format_event_dates($start_date, $end_date, $isAllDay);

		$city = tribe_get_city($post_id);
		$state = tribe_get_stateprovince($post_id);
		$country = tribe_get_country($post_id);
		$location = implode(', ', array_filter([$city, $state, $country]));

		return [
			'schedule' => $schedule,
			'location' => $location
		];
	}

	public static function format_event_dates($start_date, $end_date, $isAllDay)
	{
		$start = new DateTime($start_date);
		$end = new DateTime($end_date);

		if ($start->format('Y-m-d') === $end->format('Y-m-d')) {
			return $isAllDay
				? $start->format('F j, Y')
				: $start->format('F j, Y g:ia') . ' - ' . $end->format('g:ia');
		}

		if ($isAllDay) {
			return $start->format('Y-m') === $end->format('Y-m')
				? $start->format('F j') . '-' . $end->format('j, Y')
				: ($start->format('Y') === $end->format('Y')
					? $start->format('F j') . ' - ' . $end->format('F j, Y')
					: $start->format('F j, Y') . ' - ' . $end->format('F j, Y'));
		}

		return $start->format('Y') === $end->format('Y')
			? $start->format('F j, g:ia') . ' - ' . $end->format('F j, g:ia, Y')
			: $start->format('F j, Y') . ' - ' . $end->format('F j, Y');
	}
}
