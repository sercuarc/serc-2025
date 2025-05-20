<?php

/**
 * SERC Theme Helpers
 */

namespace Serc2025;

use DateTime;

class Helpers
{
	public static function component(string $name): string
	{
		switch ($name) {
			case 'placeholder-serc-star':
				return '<div class="relative bg-light-tertiary aspect-[11/5] overflow-hidden">' . serc_svg("serc-star", "absolute text-brand w-3/4 aspect-square left-1/4 bottom-0 translate-y-1/2 opacity-10") . '</div>';
				break;
			default:
				return '';
				break;
		}
	}

	public static function get_publications_from_field(string|array $field_name_or_data): array
	{
		if (! function_exists('get_field')) {
			return ['error' => 'Function "get_field()" not found. Please install Advanced Custom Fields plugin.'];
		}
		if (is_string($field_name_or_data)) {
			$publications_field_data = get_field($field_name_or_data);
			if (empty($publications_field_data) || ! is_array($publications_field_data)) {
				return [];
			}
		} else {
			$publications_field_data = $field_name_or_data;
		}
		$publication_ids = [];
		$technical_report_ids = [];
		$publications_image_ids = [];
		$publications_order = [];
		foreach ($publications_field_data as $pub) {
			$pub_id = $pub['publication_id'];
			$pub_namespace = $pub['publication_type'];
			$namespaced_id = self::get_publication_namespaced_id(['namespace' => $pub_namespace, 'id' => $pub_id]);
			if ($pub_namespace === 'technical-reports') {
				$technical_report_ids[] = $pub_id;
			} else {
				$publication_ids[] = $pub_id;
			}
			if ($pub['publication_image']) {
				$publications_image_ids[$namespaced_id] = $pub['publication_image'];
			}
			$publications_order[] = $namespaced_id;
		}
		$publications_merged_raw = self::fetch_publications($publication_ids, $technical_report_ids);
		if (isset($publications_merged_raw['error'])) {
			return ['error' => $publications_merged_raw['error']];
		}
		$publications = array_map(function ($pub) use ($publications_image_ids) {
			$is_tech_report = isset($pub['tr']);
			$data_key = $is_tech_report ? 'tr' : 'pub';
			$data = $pub[$data_key];
			$category = $is_tech_report ? 'Technical Report' : $data['category'];
			$namespace = $is_tech_report ? 'technical-reports' : 'publications';
			$data['namespace'] = $namespace;
			$data['category'] = $category;
			$data['icon'] = self::get_category_icon_handle($category);
			$data['url'] = home_url('/documents/' . $namespace . '/' . $data['id']);
			$data['image_id'] = $publications_image_ids[self::get_publication_namespaced_id($data)] ?? null;
			$data['date'] = $data['publication_date'] ?? $data['start_date'] ?? date('M j, Y', strtotime($data['created_at'] ?? 'now'));
			return $data;
		}, $publications_merged_raw);

		// Order publications according to the order array
		usort($publications, function ($a, $b) use ($publications_order) {
			$pos_a = array_search(self::get_publication_namespaced_id($a), $publications_order);
			$pos_b = array_search(self::get_publication_namespaced_id($b), $publications_order);
			return $pos_a - $pos_b;
		});

		return $publications;
	}

	public static function fetch_publications(array $publication_ids, array $technical_report_ids): array
	{
		$publications_response = wp_remote_get('https://web.sercuarc.org/api/collection?publications=' . implode(',', $publication_ids) . '&technical-reports=' . implode(',', $technical_report_ids));
		if (is_wp_error($publications_response)) {
			return ['error' => $publications_response->get_error_message()];
		}
		if (! $publications_json = json_decode($publications_response['body'], true)) {
			return ['error' => 'Invalid JSON response'];
		}
		return array_merge($publications_json['publications'] ?? [], $publications_json['technicalReports'] ?? []);
	}

	public static function get_publication_namespaced_id(array $publication): string
	{
		$namespace = $publication['namespace'] ?? "unknown-namespace";
		$id = $publication['id'] ?? "unknown-id";
		return $namespace . '-' . $id;
	}

	public static function get_category_icon_handle(string|null $category = ''): string
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
		$state = array_key_exists($state, self::$us_states) ? self::$us_states[$state] : $state;
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
				? $start->format('M j, Y')
				: $start->format('M j, Y g:ia') . ' - ' . $end->format('g:ia');
		}

		if ($isAllDay) {
			return $start->format('Y-m') === $end->format('Y-m')
				? $start->format('M j') . '-' . $end->format('j, Y')
				: ($start->format('Y') === $end->format('Y')
					? $start->format('M j') . ' - ' . $end->format('M j, Y')
					: $start->format('M j, Y') . ' - ' . $end->format('M j, Y'));
		}

		return $start->format('Y') === $end->format('Y')
			? $start->format('M j, g:ia') . ' - ' . $end->format('M j, g:ia, Y')
			: $start->format('M j, Y') . ' - ' . $end->format('M j, Y');
	}

	public static $us_states = [
		'Alabama' => 'AL',
		'Alaska' => 'AK',
		'Arizona' => 'AZ',
		'Arkansas' => 'AR',
		'California' => 'CA',
		'Colorado' => 'CO',
		'Connecticut' => 'CT',
		'Delaware' => 'DE',
		'Florida' => 'FL',
		'Georgia' => 'GA',
		'Hawaii' => 'HI',
		'Idaho' => 'ID',
		'Illinois' => 'IL',
		'Indiana' => 'IN',
		'Iowa' => 'IA',
		'Kansas' => 'KS',
		'Kentucky' => 'KY',
		'Louisiana' => 'LA',
		'Maine' => 'ME',
		'Maryland' => 'MD',
		'Massachusetts' => 'MA',
		'Michigan' => 'MI',
		'Minnesota' => 'MN',
		'Mississippi' => 'MS',
		'Missouri' => 'MO',
		'Montana' => 'MT',
		'Nebraska' => 'NE',
		'Nevada' => 'NV',
		'New Hampshire' => 'NH',
		'New Jersey' => 'NJ',
		'New Mexico' => 'NM',
		'New York' => 'NY',
		'North Carolina' => 'NC',
		'North Dakota' => 'ND',
		'Ohio' => 'OH',
		'Oklahoma' => 'OK',
		'Oregon' => 'OR',
		'Pennsylvania' => 'PA',
		'Rhode Island' => 'RI',
		'South Carolina' => 'SC',
		'South Dakota' => 'SD',
		'Tennessee' => 'TN',
		'Texas' => 'TX',
		'Utah' => 'UT',
		'Vermont' => 'VT',
		'Virginia' => 'VA',
		'Washington' => 'WA',
		'West Virginia' => 'WV',
		'Wisconsin' => 'WI',
		'Wyoming' => 'WY',
	];
}
