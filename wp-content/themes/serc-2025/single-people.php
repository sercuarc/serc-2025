<?php

/**
 * People Single
 */

$member_roles = wp_get_post_terms($post->ID, "member_roles");

// if SERC Staff, redirect to People page
if ($member_roles[0]->slug === "serc-staff") {
	wp_redirect(home_url('/people'));
}

$role = $member_roles[0]->name;
$breadcrumbs = [
	'People' => home_url('/people'),
	$role => home_url('/people?' . http_build_query(['tab' => $member_roles[0]->slug]))
];

get_header();
?>

<main>
	<header class="hero lg:pb-26">
		<div class="container">
			<?php get_template_part('components/breadcrumbs', '', [
				'breadcrumbs' => $breadcrumbs
			]); ?>
		</div>
		<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-16 items-center">
			<div class="lg:col-span-2">
				<h1 class="text-h2"><?php the_title(); ?></h1>
				<h2 class="text-h4 mt-6"><?php the_field("job_title"); ?></h2>
				<?php $organizations = wp_get_post_terms($post->ID, "organizations"); ?>
				<?php if (!empty($organizations)) : ?>
					<p class="flex items-center gap-2 uppercase mt-7">
						<?php echo serc_svg("institution", "inline text-brand size-5 mr-1"); ?>
						<?php echo $organizations[0]->name; ?>
					</p>
				<?php endif; ?>
			</div>
			<div>
				<?php the_post_thumbnail('medium', array('class' => 'aspect-square object-cover')); ?>
			</div>
		</div>
	</header>
	<section class="py-12 lg:py-20">
		<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-start">
			<div class="lg:col-span-2">
				<h3 class="text-[1.75rem] mb-10"><strong>About</strong></h3>
				<div class="wysiwyg wysiwyg-lg">
					<?php the_content(); ?>
				</div>
			</div>
			<div>
				<?php $expertise = wp_get_post_terms($post->ID, "expertise"); ?>
				<?php if (! empty($expertise)) : ?>
					<h3 class="text-[1.75rem] mb-10">
						<?php echo serc_svg("badge", "inline text-brand size-8 mr-1"); ?>
						<strong>Expertise</strong>
					</h3>
					<ul class="text-lg lg:text-xl flex flex-col gap-4">
						<?php foreach ($expertise as $expertise_item) : ?>
							<li><?php echo $expertise_item->name; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>