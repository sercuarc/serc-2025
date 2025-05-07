<?php
$title = $args['title'] ?? 'Email Newsletter';
$description = $args['description'] ?? '';
?>

<div class="relative py-16 lg:py-30 bg-light-secondary">
	<img src="<?php echo get_template_directory_uri() . "/assets/images/nasa-vault.jpg"; ?>" alt="nasa vault" class="absolute top-0 left-0 object-cover w-full h-full" />
	<div class="relative z-10 container max-w-[813px] bg-white/95 border-t-4 border-brand py-10 lg:py-14 px-12 lg:px-18 flex flex-col gap-6 lg:gap-8">
		<h2 class="text-title-2 text-center">
			<?php echo esc_html($title); ?>
		</h2>
		<?php if ($description) : ?>
			<div class="text-center">
				<?php echo $description; ?>
			</div>
		<?php endif; ?>
		<div id="newsletter-signup" class="is-featured w-full max-w-[450px] mx-auto">
			<?php get_template_part("components/gravity-form", null, ["id" => 2]) ?>
		</div>
	</div>
</div>