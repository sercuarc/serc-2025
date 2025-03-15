<?php

/**
 * SERC Theme Helpers
 */

class SercHelpers
{
	public static function formatEventDates($start_date, $end_date, $isAllDay)
	{
		$start = new DateTime("@{$start_date}");
		$end = new DateTime("@{$end_date}");

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
