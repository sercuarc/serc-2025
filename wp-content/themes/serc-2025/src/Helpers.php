<?php

/**
 * SERC Theme Helpers
 */

namespace Serc2025;

use DateTime;

class Helpers
{
	public static function get_publications(array $publication_ids, array $technical_report_ids, array $order = []): array
	{
		$publications_response = wp_remote_get('https://web.sercuarc.org/api/collection?publications=' . implode(',', $publication_ids) . '&technical-reports=' . implode(',', $technical_report_ids));
		if (is_wp_error($publications_response)) {
			return ['error' => $publications_response->get_error_message()];
		}

		$publications_json = json_decode($publications_response['body'], true);
		$publications_merged_raw = array_merge($publications_json['publications'] ?? [], $publications_json['technicalReports'] ?? []);
		$publications = array_map(function ($pub) {
			$is_tech_report = isset($pub['tr']);
			$data_key = $is_tech_report ? 'tr' : 'pub';
			$data = $pub[$data_key];
			$category = $is_tech_report ? 'Technical Report' : $data['category'];
			$namespace = $is_tech_report ? 'technical-reports' : 'publications';
			$data['namespace'] = $namespace;
			$data['category'] = $category;
			$data['icon'] = self::get_category_icon_handle($category);
			$data['url'] = home_url('/documents/' . $namespace . '/' . $data['id']);
			return $data;
		}, $publications_merged_raw);

		// Order publications according to the order array
		if (! empty($order)) {
			$publications = array_filter($publications, function ($pub) use ($order) {
				return in_array(self::get_publication_namespaced_id($pub), $order);
			});
			usort($publications, function ($a, $b) use ($order) {
				$pos_a = array_search(self::get_publication_namespaced_id($a), $order);
				$pos_b = array_search(self::get_publication_namespaced_id($b), $order);
				return $pos_a - $pos_b;
			});
		}

		return $publications;
	}

	public static function get_publication_namespaced_id(array $publication): string
	{
		if (empty($publication['namespace'])) {
			throw new \Exception("Cannot form a namespaced ID. Publication missing key 'namespace'.");
		}
		if (empty($publication['id'])) {
			throw new \Exception("Cannot form a namespaced ID. Publication missing key 'id'.");
		}
		return $publication['namespace'] . '-' . $publication['id'];
	}

	public static function get_category_icon_handle(string $category = ''): string
	{
		switch (strtolower(trim($category))) {
			case 'presentation':
				return 'presentation';
			case 'video':
				return 'video';
			case 'event':
			case 'events':
				return 'calendar';
			case 'news':
			case 'journal article':
				return 'news';
			case 'update':
				return 'pin';
			case 'institution':
				return 'institution';
			default:
				return 'paper';
		}
	}

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
