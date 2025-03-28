<?php

/**
 * Template Name: People Landing
 */
?>

<?php get_header(); ?>

<?php $image = null; ?>

<?php
$default_people_args = [
	'numberposts' => -1,
	'post_type' => 'people',
	'order' => 'ASC',
	'orderby' => [
		'sort_order' => 'ASC',
		'date' => 'DESC',
	]
];
$leadership_query = ['tax_query' => [
	[
		'taxonomy' => 'member_roles',
		'field' => 'slug',
		'terms' => 'leadership',
	]
]];
$research_query = ['tax_query' => [
	[
		'taxonomy' => 'member_roles',
		'field' => 'slug',
		'terms' => 'research-council',
	]
]];
$advisory_query = ['tax_query' => [
	[
		'taxonomy' => 'member_roles',
		'field' => 'slug',
		'terms' => 'advisory-board',
	]
]];
$member_roles = [
	["slug" => "leadership", "label" => "Leadership", "people" => get_posts(array_merge($default_people_args, $leadership_query))],
	["slug" => "research-council", "label" => "Research Council", "people" => get_posts(array_merge($default_people_args, $research_query))],
	["slug" => "advisory-board", "label" => "Advisory Board", "people" => get_posts(array_merge($default_people_args, $advisory_query))],
];
?>

<main>
	<header class="hero <?php if ($image) : ?>hero--inverted hero--with-image<?php endif; ?>">
		<?php if ($image) : ?>
			<?php echo $image; ?>
		<?php endif; ?>
		<div class="container">
			<h1 class="text-h1">People</h1>
		</div>
	</header>
	<section class="bg-white pt-12 lg:pt-16">

		<div data-tabs>
			<div class="container">
				<nav class="tab-menu flex gap-0 overflow-y-hidden overflow-x-auto">
					<?php $count = 0;
					foreach ($member_roles as $member_role) : ?>
						<a data-tab href="#<?php echo $member_role["slug"] ?>" class="tab <?php echo $count === 0 ? "is-active" : "" ?>"><?php echo $member_role["label"] !== "Leadership" ? $member_role["label"] : "Operations"; ?></a>
					<?php $count++;
					endforeach; ?>
				</nav>
			</div>
			<div class="tab-content-wrapper">
				<?php $count = 0;
				foreach ($member_roles as $role) : ?>
					<?php if (! empty($role["people"])) : ?>
						<div data-tab-content id="<?php echo $role["slug"] ?>" class="tab-content <?php echo $count === 0 ? 'is-active' : '' ?>">
							<div class="container my-20 lg:my-30">
								<h2 class="text-title-1 text-center"><?php echo $role["label"] ?></h2>
								<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-12 lg:mt-20 -mx-4">
									<?php foreach ($role["people"] as $person) : ?>
										<a href="<?php echo get_the_permalink($person->ID) ?>" class="group/person-card-lg flex flex-col sm:flex-row gap-8 p-4 bg-white hover:shadow-lg focus:shadow-lg outline-0 transition-all">
											<div class="mx-auto sm:mx-0">
												<?php if (has_post_thumbnail($person->ID)) : ?>
													<?php echo get_the_post_thumbnail($person->ID, 'medium', ["class" => "w-48 h-48 object-cover"]) ?>
												<?php else : ?>
													<?php get_template_part("components/avatar-placeholder", null, ["class" => "w-48 h-48"]) ?>
												<?php endif; ?>
											</div>
											<div class="flex flex-col gap-6 text-center sm:text-left">
												<h3 class="text-h4 leading-none text-light-surface-strong group-hover/person-card-lg:text-brand transition-colors"><?php echo $person->post_title ?></h3>
												<p class="label-base text-light-surface-strong">[TITLE]</p>
												<p class="text-xs leading-none uppercase text-light-surface-normal">
													<?php echo serc_svg("institution", "inline text-brand size-3 mr-1"); ?>
													[INSTITUTE*]
												</p>
											</div>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
							<?php if ($role["slug"] === "leadership") : ?>
								<?php $staff = get_people("staff"); ?>
								<?php if ($staff) : ?>
									<div class="bg-light-tertiary py-20 lg:py-30">
										<div class="container">
											<h2 class="text-title-1 text-center">Staff</h2>
											<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 md:gap-x-12 xl:gap-x-28 gap-y-12 mt-12 lg:mt-20">
												<?php foreach ($staff as $person) : ?>
													<div class="group/person-card-lg flex flex-col gap-5 text-center sm:text-left">
														<h3 class="text-h4 leading-none text-light-surface-strong transition-colors">
															<?php echo ($person->prefix) . $person->first_name . ' ' . $person->middle_name . ' ' . $person->last_name . ' ' . $person->suffix; ?>
														</h3>
														<p class="label-base text-light-surface-strong">
															<?php foreach ($person->titles as $title) {
																echo $title->current == 'yes' ? $title->job_title : "";
															} ?>
														</p>
														<p class="text-xs leading-none uppercase text-light-surface-normal">
															<?php echo serc_svg("institution", "inline text-brand size-3 mr-1"); ?>
															<?php echo $person->organizations[0]->organization_name; ?>
														</p>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php $count++;
				endforeach; ?>
			</div>
		</div>

	</section>

</main>

<?php get_footer(); ?>