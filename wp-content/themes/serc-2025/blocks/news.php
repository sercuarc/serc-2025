<?php
$title = get_field('news_title') ?: (is_admin() ? 'Add a Title (optional)' : "");
$description = get_field('news_description') ?: (is_admin() ? 'Add a description (optional)' : "");
$get_static_posts = get_field('news_get_static_posts') ?: false;
$button = get_field('news_button') ?: (is_admin() ? ['title' => 'Add a Button (optional)', 'url' => '#', 'target' => '_self'] : null);

if (! $get_static_posts || ! $posts = get_field('news_posts')) {
	$posts = get_posts([
		'post_type' => 'post',
		'posts_per_page' => 4,
		'post_status' => 'publish',
	]);
}

$posts = array_map(function ($post) {
	$is_update = has_category('update', $post);
	$icon = $is_update ? 'pin' : 'news';
	$category = $is_update ? 'Update' : 'News';
	return [
		'image'   		=> get_the_post_thumbnail($post, 'small', ['class' => 'w-full aspect-video object-cover']),
		'label_above' => '<span class="flex items-center">' . serc_svg($icon, 'inline-block text-brand size-5 mr-2') . ' ' . $category . '</span>',
		'title'   		=> get_the_title($post),
		'url'     		=> get_permalink($post),
		'text' 				=> '<span class="uppercase">' . get_the_date('M j, Y', $post) . '</span> – ' . wp_trim_words($post->post_excerpt ?: $post->post_content, 15),
		'cta' 				=> 'Read More',
		'contained'   => false,
		'class'				=> 'pt-4 md:pt-0 md:px-4 not-first:border-t md:not-first:border-t-0 md:even:border-l lg:not-first:border-l border-subtle',
	];
}, $posts);
?>

<div class="py-16 lg:py-30 bg-light-secondary">
	<div class="container flex flex-col gap-8 lg:gap-14">
		<div>
			<?php if ($title) : ?>
				<h2 class="text-title-1 text-center">
					<?php echo esc_html($title); ?>
				</h2>
			<?php endif; ?>
			<?php if ($description) : ?>
				<div class="body-lg text-center w-full max-w-[670px] mx-auto mt:6 lg:mt-8">
					<?php echo $description; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-4 content-start">
			<?php foreach ($posts as $post) : ?>
				<?php get_template_part('components/card-vert', null, $post); ?>
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