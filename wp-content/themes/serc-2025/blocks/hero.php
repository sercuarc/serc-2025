<?php
$title = get_field('hero_title');
$subtitle = get_field('hero_subtitle');
$blur_bg = false;
$hide_right_column_on_mobile = false;
$right_column_html = '';

// Right Column
$right_column_content = get_field('hero_right_column_content');
if ($right_column_content == 'event') {
	$event = get_field('hero_event');
	if (tribe_event_is_multiday($event)) {
		$date = tribe_get_start_date($event, false, 'M j') . ' - ' . tribe_get_end_date($event, false, 'M j, Y');
	} else {
		$date = tribe_get_start_date($event, false, 'M j, Y');
	}
	ob_start();
	get_template_part('components/card-vert', null, [
		'label_above' => '<span class="flex items-center gap-2">' . serc_svg('calendar', 'size-4 text-brand') . ' Featured Event</span>',
		'title' => get_the_title($event),
		'text' => $date,
		'url' => get_permalink($event),
		'cta' => 'Read More',
		'contained' => false,
		'class' => 'bg-white hover:shadow-lg border-brand border-t-4 border-solid px-7 py-3'
	]);
	$hide_right_column_on_mobile = true;
	$right_column_html = ob_get_clean();
} elseif ($right_column_content == 'publication') {
	$feat_report_id = get_field('hero_featured_report_id');
	$feat_report_type = get_field('hero_featured_report_type');
	$feat_report_response = wp_remote_get('https://web.sercuarc.org/api/' . $feat_report_type . '/' . $feat_report_id);
	if (is_wp_error($feat_report_response)) {
		$right_column_html = 'Error fetching featured report #' . $feat_report_id;
	} else {
		$feat_report_json = json_decode($feat_report_response['body'], true);
		$feat_report = $feat_report_json['pub'] ?? $feat_report_json['tr'] ?? null;
		if (! $feat_report) {
			$right_column_html = 'Featured report #' . $feat_report_id . ' not found.';
		} else {
			ob_start();
			get_template_part('components/card-vert', null, [
				'label_above' => '<span class="flex items-center gap-2">' . serc_svg('paper', 'size-4 text-brand') . ' Featured Report</span>',
				'title' => $feat_report['title'],
				'text' => $feat_report['publication_date'] ?? $feat_report['start_date'],
				'url' => home_url('documents/' . $feat_report_type . '/' . $feat_report['id']),
				'cta' => 'Read More',
				'contained' => false,
				'class' => 'bg-white hover:shadow-lg border-brand border-t-4 border-solid px-7 py-3'
			]);
			$hide_right_column_on_mobile = true;
			$right_column_html = ob_get_clean();
		}
	}
} elseif ($right_column_content == 'image') {
	$image = get_field('hero_image');
	$blur_bg = true;
	$right_column_html = wp_get_attachment_image($image, 'small', false, ['class' => 'hero-image']);
}

// Button
$button = get_field('hero_button');
$button_html = '';
if ($button) {
	$button_html = '<a href="' . $button['url'] . '" class="btn btn-primary btn-lg" target="' . $button['target'] . '" rel="noopener noreferrer">' . $button['title'] . '</a>';
}

get_template_part('components/hero', null, [
	'right_column' => $right_column_html,
	'hide_right_column_on_mobile' => $hide_right_column_on_mobile,
	'bg_image' => wp_get_attachment_image(get_field('hero_bg_image'), 'large', false, [
		'class' => 'hero-bg-image'
	]),
	'blur_bg' => $blur_bg,
	'title' => $title,
	'title_class' => 'text-h1',
	'subtitle' => $subtitle,
	'description' => $button_html,
	'description_class' => 'mt-7 text-lg lg:text-xl',
	'center_y' => true
]);
