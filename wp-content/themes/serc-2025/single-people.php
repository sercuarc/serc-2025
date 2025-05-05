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
$organizations = wp_get_post_terms($post->ID, "organizations");

get_header();
?>

<main>
	<?php get_template_part('components/hero', null, [
		'right_column' => get_the_post_thumbnail($post, 'medium', ['class' => 'hero-image aspect-square object-cover']),
		'breadcrumbs' => $breadcrumbs,
		'title' => get_the_title(),
		'subtitle' => get_field("job_title"),
		'description' => serc_svg("institution", "inline text-brand size-5 mr-1") . '<span class="uppercase">' . $organizations[0]->name . '</span>'
	]); ?>
	<section class="py-12 lg:py-20">
		<div class="container grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-start">
			<div class="lg:col-span-2">
				<h3 class="text-[1.75rem] mb-10"><strong>About</strong></h3>
				<div class="wysiwyg wysiwyg--lg">
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