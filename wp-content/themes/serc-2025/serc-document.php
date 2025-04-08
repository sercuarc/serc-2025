<?php
$type = get_query_var('serc_document_type');
$id   = get_query_var('serc_document_id');

// Example remote fetch
$response = wp_remote_get("https://web.sercuarc.org/api/{$type}/{$id}");

if (! is_wp_error($response)) {
	$data = json_decode(wp_remote_retrieve_body($response), true);
	$content = isset($data['pub']) ? $data['pub'] : (isset($data['tr']) ? $data['tr'] : null);
	if (! $content) {
		wp_redirect('/404', 301, '');
	}
} else {
	wp_redirect('/404', 301, '');
}

$date_string = isset($content['publication_date']) ? $content['publication_date'] : $content['start_date'];
$date_formatted = date_format(new DateTime($date_string), 'F j, Y');

get_header(); ?>

<main>
	<header class="hero lg:pb-26">
		<?php echo serc_svg("serc-star", "absolute text-[#A69181] size-[720px] left-1/2 bottom-0 translate-y-1/2 opacity-10"); ?>
		<div class="container">
			<?php get_template_part('components/breadcrumbs', '', [
				'breadcrumbs' => [
					'Research' => home_url('/publications'),
					'Publications' => home_url('/search?doc_types=publications')
				]
			]); ?>
		</div>
		<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-16 items-center">
			<div class="lg:col-span-2">
				<h1 class="text-h2 !font-normal capitalize"><?php echo $content['title']; ?></h1>
				<p class="uppercase mt-7 flex items-center gap-6">
					<span>
						<?php echo serc_svg("calendar", "inline-block align-middle text-brand size-4 mr-1"); ?>
						<?php echo $date_formatted; ?>
					</span>
					<span>
						<?php echo serc_svg("paper", "inline-block align-middle text-brand size-4 mr-1"); ?>
						<?php echo isset($content['category']) ? $content['category'] : $content['type']; ?>
					</span>
				</p>
			</div>
		</div>
	</header>
	<section class="bg-white pt-12 lg:pt-16 pb-20 lg:pb-30">
		<div class="container grid grid-cols-1 lg:grid-cols-4 gap-9 lg:gap-18 items-start">
			<div class="lg:col-span-3 flex flex-col gap-10 lg:gap-20">
				<div>
					<h2 class="text-title-2">Details</h2>
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-9 lg:gap-18 mt-12">
						<dl class="flex flex-col gap-6">
							<?php if (isset($content['authors']) && count($content['authors']) > 0) : ?>
								<div>
									<dt class="label-base text-light-surface-subtle">Research Team</dt>
									<dd class="text-base text-dark-main mt-3">
										<?php echo implode(", ", array_map(function ($author) {
											$prefix = isset($author['prefix']) ? $author['prefix'] . ' ' : '';
											$first = isset($author['first_name']) ? $author['first_name'] : '';
											$last = isset($author['last_name']) ? $author['last_name'] : '';
											return "$prefix$first $last";
										}, $content['authors'])); ?>
									</dd>
								</div>
							<?php endif; ?>
							<?php if (isset($content['authors2']) && count($content['authors2']) > 0) : ?>
								<div>
									<dt class="label-base text-light-surface-subtle">Collaborators</dt>
									<dd class="text-base text-dark-main mt-3">
										<?php echo implode(", ", array_map(function ($author) {
											$prefix = isset($author['prefix']) ? $author['prefix'] . ' ' : '';
											$first = isset($author['first_name']) ? $author['first_name'] : '';
											$last = isset($author['last_name']) ? $author['last_name'] : '';
											return "$prefix$first $last";
										}, $content['authors2'])); ?>
									</dd>
								</div>
							<?php endif; ?>
							<?php if (isset($content['event_name']) && $content['event_name']) : ?>
								<div>
									<dt class="label-base text-light-surface-subtle">Event</dt>
									<dd class="flex flex-col gap-2 text-base text-dark-main mt-3">
										<span><?php echo $content['event_name']; ?></span>
										<span><?php echo $content['location']; ?></span>
										<span>
											<?php
											$start_date = isset($content['start_date']) ? $content['start_date'] : '';
											$end_date = isset($content['end_date']) ? $content['end_date'] : '';
											if ($start_date === $end_date) {
												$start_formatted = date_format(new DateTime($start_date), 'M j, Y');
												echo $start_formatted;
											} else {
												$start_formatted = date_format(new DateTime($start_date), 'M j');
												$end_formatted = date_format(new DateTime($end_date), 'M j, Y');
												echo $start_date === $end_date ? $start_formatted : $start_formatted . ' - ' . $end_formatted;
											} ?>
										</span>
									</dd>
								</div>
							<?php endif; ?>
						</dl>
						<dl class="lg:col-span-2 flex flex-col gap-6">
							<?php
							$has_research_programs = isset($content['research_programs']) && count($content['research_programs']) > 0;
							$has_research_tasks = isset($content['research_tasks']) && count($content['research_tasks']) > 0;
							if ($has_research_programs || $has_research_tasks) : ?>
								<div>
									<dt class="label-base text-light-surface-subtle">Focus Area</dt>
									<dd class="text-base text-dark-main mt-3">
										<?php if ($has_research_programs) {
											echo implode("<br>", array_map(fn($org) => $org['research_program_name'], $content['research_programs']));
										} ?>
										<?php if ($has_research_tasks) {
											echo implode("<br>", array_map(fn($org) => $org['task_name'], $content['research_tasks']));
										} ?>
									</dd>
								</div>
							<?php endif; ?>
							<div>
								<dt class="label-base text-light-surface-subtle">University / Organization</dt>
								<dd class="text-base text-dark-main mt-3">
									<?php echo implode("<br>", array_map(fn($org) => $org['organization_name'], $data['org'])); ?>
								</dd>
							</div>
						</dl>
						<div class="flex flex-col gap-6"></div>
					</div>
				</div>
				<?php if (isset($content['abstract'])) : ?>
					<div>
						<h2 class="text-title-2">Abstract</h2>
						<div class="wysiwyg mt-12"><?php echo $content['abstract']; ?></div>
					</div>
				<?php endif; ?>
				<?php if (isset($content['description'])) : ?>
					<div>
						<h2 class="text-title-2">Description</h2>
						<div class="wysiwyg mt-12"><?php echo $content['description']; ?></div>
					</div>
				<?php endif; ?>
			</div>
			<div class="lg:col-span-1">
				<h3 class="text-h5">Share</h3>
				<div class="flex items-center gap-4 mt-8">
					<button title="Copy URL" class="p-2 outline-0 hover:bg-[#00000008] text-light-surface-subtle hover:text-light-surface-normal focus:text-light-surface-normal border border-subtle hover:border-normal focus:border-normal transition-all"><?php echo serc_svg('link', 'block size-4') ?><span class="sr-only">Copy link</span></button>
					<a href="#linkedin" title="LinkedIn" class="p-2 outline-0 hover:bg-[#00000008] text-light-surface-subtle hover:text-light-surface-normal focus:text-light-surface-normal border border-subtle hover:border-normal focus:border-normal transition-all"><?php echo serc_svg('linkedin', 'block size-4') ?><span class="sr-only">LinkedIn</span></a>
					<a href="#facebook" title="YouTube" class="p-2 outline-0 hover:bg-[#00000008] text-light-surface-subtle hover:text-light-surface-normal focus:text-light-surface-normal border border-subtle hover:border-normal focus:border-normal transition-all"><?php echo serc_svg('facebook', 'block size-4') ?><span class="sr-only">Facebook</span></a>
				</div>
				<h3 class="text-h5 mt-12">Downloads</h3>
				<div class="flex flex-col gap-4 mt-8">
					<a href="<?php echo $content['file_s3']; ?>" download="<?php echo $content['file']; ?>" target="_blank" class="btn btn-primary">Download Report (PDF) <?php echo serc_svg('download', 'inline-block size-4') ?></a>
					<!-- <a href="#" class="text-brand hover:text-dark-main">Additional Download (PDF) <?php echo serc_svg('download', 'inline-block size-4') ?></a> -->
				</div>
				<?php if (isset($content['image_s3']) && $content['image_s3']) : ?>
					<div class="flex flex-col gap-4 mt-8">
						<img src="<?php echo $content['image_s3']; ?>" alt="<?php echo $content['image']; ?>" class="block w-full h-auto shadow" width="300" height="400" />
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>