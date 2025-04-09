<?php

/**
 * Registers the WP-CLI command to import people from remote JSON APIs.
 */

if (defined('WP_CLI') && WP_CLI) {
	WP_CLI::add_command('serc-import-people', 'CommandImportPeople');
}

class CommandImportPeople
{
	public function __invoke($args, $assoc_args)
	{
		$endpoints = [
			'https://web.sercuarc.org/api/people?roles=Leadership',
			'https://web.sercuarc.org/api/people?roles=Research%20Council',
			'https://web.sercuarc.org/api/people?roles=Advisory%20Board',
			'https://web.sercuarc.org/api/people?roles=SERC%20Staff',
		];

		$combined_data = [];

		foreach ($endpoints as $url) {
			WP_CLI::log("Fetching data from: $url");
			$response = wp_remote_get($url);

			if (is_wp_error($response)) {
				WP_CLI::warning("Failed to fetch from $url. Skipping.");
				continue;
			}

			$json = json_decode(wp_remote_retrieve_body($response), true);

			if (! is_array($json)) {
				WP_CLI::warning("Invalid JSON at $url. Skipping.");
				continue;
			}

			$combined_data = array_merge($combined_data, $json);
		}

		if (empty($combined_data)) {
			WP_CLI::error('No valid data found from any endpoint.');
		}

		foreach ($combined_data as $entry) {
			$serc_id = $entry['id'] ?? null;
			if (! $serc_id) {
				WP_CLI::warning('Missing ID in entry. Skipping.');
				continue;
			}

			$existing_post = $this->find_post_by_serc_id($serc_id);

			$full_name = trim(implode(' ', array_filter([
				$entry['first_name'] ?? '',
				$entry['middle_name'] ?? '',
				$entry['last_name'] ?? ''
			])));

			$post_data = [
				'post_type'    => 'people',
				'post_title'   => $full_name,
				'post_content' => $entry['biography'] ?? '',
				'post_status'  => 'publish'
			];

			if ($existing_post) {
				$post_data['ID'] = $existing_post->ID;
				$post_id = wp_update_post($post_data);
				WP_CLI::log("Updated: {$full_name} (ID: {$post_id})");
			} else {
				$post_id = wp_insert_post($post_data);
				WP_CLI::log("Created: {$full_name} (ID: {$post_id})");
			}

			if (is_wp_error($post_id)) {
				WP_CLI::warning("Failed to save post for {$full_name}");
				continue;
			}

			// Always update SERC ID
			update_field('serc_id', $serc_id, $post_id);

			// ACF Fields
			update_field('prefix', $entry['prefix'] ?? '', $post_id);
			update_field('suffix', $entry['suffix'] ?? '', $post_id);
			update_field('job_title', $entry['titles'][0]['job_title'] ?? '', $post_id);

			// Taxonomies
			if (! empty($entry['roles'])) {
				$roles = array_column($entry['roles'], 'role_name');
				wp_set_post_terms($post_id, $roles, 'member_roles');
			}

			if (! empty($entry['organizations'])) {
				$orgs = array_column($entry['organizations'], 'organization_name');
				wp_set_post_terms($post_id, $orgs, 'organizations');
			}

			// Import or update thumbnail
			if (! empty($entry['image_s3'])) {
				$image_id = $this->import_external_image($entry['image_s3'], $post_id);
				if ($image_id) {
					set_post_thumbnail($post_id, $image_id);
				}
			}
		}

		WP_CLI::success('Import complete.');
	}

	private function find_post_by_serc_id($serc_id)
	{
		$query = new WP_Query([
			'post_type'  => 'people',
			'meta_query' => [
				[
					'key'   => 'serc_id',
					'value' => $serc_id
				]
			],
			'posts_per_page' => 1,
			'fields' => 'all'
		]);

		return $query->have_posts() ? $query->posts[0] : null;
	}

	private function import_external_image($image_url, $post_id)
	{
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$tmp = download_url($image_url);
		if (is_wp_error($tmp)) {
			WP_CLI::warning("Failed to download image: $image_url");
			return false;
		}

		$file_array = [
			'name'     => basename($image_url),
			'tmp_name' => $tmp
		];

		$id = media_handle_sideload($file_array, $post_id);
		if (is_wp_error($id)) {
			WP_CLI::warning("Failed to sideload image: $image_url");
			return false;
		}

		return $id;
	}
}
