<?php

use Serc2025\Helpers;

$title = get_field('publications_title') ?: (is_admin() ? 'Add a Title (optional)' : "");
$description = get_field('publications_description') ?: (is_admin() ? 'Add a description (optional)' : "");
$button = get_field('publications_button') ?: (is_admin() ? ['title' => 'Add a Button (optional)', 'url' => '#', 'target' => '_self'] : null);

$publication_ids = [];
$technical_report_ids = [];
$publications = [
	[
		'id' => 1,
		'title' => 'Digital Engineering Implications on Decision Making Process',
		'abstract' => 'Abbreviated excerpt from the abstract goes here so that the user can ascertain what the paper is about and decide if they want to click or not in order to read more...',
		'type' => 'Technical Report',
		'date' => 'JAN 16, 2025',
	],
	[
		'id' => 2,
		'title' => 'Enablers to Systems Engineering Modernization',
		'abstract' => 'There is a need to develop Systems Engineering (SE) Guidance for Program Managers that address the correct toolkit inclusive of priorities pertaining to Digital Engineering...',
		'category' => 'Presentation',
		'date' => 'DEC 12, 2024',
	],
	[
		'id' => 3,
		'title' => 'Emerging Technologies in Military Environment',
		'date' => 'DEC 2, 2024',
		'abstract' => 'There are two change happening in commercial parts including migration to copper-wirebonding and the emergence of leadfree solders for first, second-level interconnects...',
		'category' => 'Video',
	]
];

$publications = array_map(function ($pub) {
	$is_tech_report = isset($pub['type']) && $pub['type'] === 'Technical Report';
	$type = $is_tech_report ? 'Technical Report' : $pub['category'];
	$url_path = $is_tech_report ? 'technical-reports' : 'publications';
	$icon = Helpers::get_category_icon_handle($type);
	return [
		'cta' 				=> 'Read More ' . serc_svg('arrow-right', 'inline text-brand size-5 ml-1 transition-transform group-hover/card:translate-x-2'),
		'date'   			=> $pub['date'],
		'image'   		=> $pub['image'] ?? '<div class="relative bg-light-tertiary aspect-[11/5] overflow-hidden">' . serc_svg("serc-star", "absolute text-brand w-3/4 aspect-square left-1/4 bottom-0 translate-y-1/2 opacity-10") . '</div>',
		'label_above' => '<span class="flex items-center">' . serc_svg($icon, 'inline-block text-brand size-5 mr-2') . ' ' . $type . '</span>',
		'text' 				=> $pub['date'] . ' – ' . wp_trim_words($pub['abstract'], 25),
		'title'   		=> $pub['title'],
		'url'     		=> home_url('/documents/' . $url_path . '/' . $pub['id']),
	];
}, $publications);
?>

<div class="py-16 lg:py-30 bg-light-secondary">
	<div class="container flex flex-col gap-8 lg:gap-14">
		<div>
			<?php if ($title) : ?>
				<h2 class="text-title-1 text-center">
					<?php echo $title; ?>
				</h2>
			<?php endif; ?>
			<?php if ($description) : ?>
				<div class="body-lg text-center w-full max-w-[670px] mx-auto mt:6 lg:mt-8">
					<?php echo $description; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ($publications as $pub) : ?>
				<?php get_template_part('components/card-vert', null, $pub); ?>
			<?php endforeach; ?>
		</div>
		<?php if ($button) : ?>
			<div class="text-center">
				<a href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target']); ?>" rel="noopener noreferrer" class="btn btn-primary">
					<?php echo esc_html($button['title']); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>