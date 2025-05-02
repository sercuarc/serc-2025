<?php
$newsletter_display = get_field('newsletter_display');
$menus = [
	["id" => "menu-1", "label" => "About", "items" => [["label" => "About SERC", "url" => "#"], ["label" => "People", "url" => "#"]]],
	["id" => "menu-2", "label" => "Research", "items" => [["label" => "Our Research", "url" => "#"], ["label" => "Research Publications", "url" => "#"]]],
	["id" => "menu-3", "label" => "Events & News", "items" => [['label' => 'Events', 'url' => '#'], ['label' => 'SERC Research Review', 'url' => '#'], ['label' => 'AI4SE & SE4AI Workshop', 'url' => '#'], ['label' => 'News', 'url' => '#']],],
	["id" => "menu-4", "label" => "", "items" => [['label' => 'Resources & Partners', 'url' => '#'], ['label' => 'Search', 'url' => '#'], ['label' => 'Contact', 'url' => '#'], ['label' => 'SEBoK', 'url' => '#']],],
]; ?>

<footer>
	<?php if ($newsletter_display === "featured") : ?>
		<?php get_template_part("components/newsletter", null, [
			'title' => get_field('newsletter_title', 'option') ?: 'Email Newsletter',
			'description' => get_field('newsletter_description', 'option'),
		]); ?>
	<?php else : ?>
		<?php get_template_part("components/sign-up"); ?>
	<?php endif; ?>
	<div class="bg-dark-main text-dark-surface-subtle pt-10 lg:pt-18 pb-20">
		<div class="container max-w-[88rem]">
			<div class="flex flex-col xl:flex-row gap-12 xl:gap-30">
				<div class="flex flex-col gap-8">
					<a href="<?php echo home_url(); ?>" class="block w-[276px] h-[74px] shrink-0 focus:outline-white">
						<img src="<?php echo get_template_directory_uri() . "/assets/images/logo-horz-white.svg"; ?>" alt="SERC Logo" width="276" height="74" class="w-full h-full object-contain">
					</a>
					<div class="flex items-center gap-4">
						<a href="#youtube" title="YouTube" class="p-2 outline-0 text-dark-surface-subtle hover:text-white focus:text-white border border-dark-tertiary hover:border-white focus:border-white transition-all"><?php echo serc_svg('youtube', 'block size-4') ?><span class="sr-only">YouTube</span></a>
						<a href="#linkedin" title="LinkedIn" class="p-2 outline-0 text-dark-surface-subtle hover:text-white focus:text-white border border-dark-tertiary hover:border-white focus:border-white transition-all"><?php echo serc_svg('linkedin', 'block size-4') ?><span class="sr-only">LinkedIn</span></a>
					</div>
				</div>
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 xl:gap-18 xl:ml-auto">
					<?php foreach ($menus as $menu) : ?>
						<nav
							class="flex flex-col gap-4 w-1/2 md:w-full">
							<?php if ($menu["label"]) : ?>
								<div class="font-bold"><?php echo $menu["label"]; ?></div>
							<?php else : ?>
								<div class="hidden md:block">&nbsp;</div>
							<?php endif; ?>
							<hr class="border-t-2 border-brand">
							<ul class="flex flex-col gap-4">
								<?php foreach ($menu["items"] as $item) : ?>
									<li><a href="<?php echo $item["url"]; ?>" class="block leading-snug text-sm xl:text-base text-white hover:text-brand transition-all focus:outline-white"><?php echo $item["label"]; ?></a></li>
								<?php endforeach; ?>
							</ul>
						</nav>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="mt-12">
				<div class="text-3xl font-bold">
					<img src="<?php echo get_template_directory_uri() . "/assets/images/airc-white.png"; ?>" alt="AIRC Logo" width="72" height="24" class="inline-block object-contain">
				</div>
				<p class="text-sm text-white mt-1">Visit our sister research center at <a href="https://acqirc.org/" class="hover:text-brand transition-colors focus:outline-white"><strong>acqirc.org</strong></a></p>
			</div>
			<hr class="my-8">
			<div class="flex flex-col md:flex-row gap-4 md:gap-16 text-sm xl:text-base">
				<div class="text-dark-surface-subtle">
					Copyright &copy; <?php echo date("Y"); ?>&nbsp;<br class="md:hidden">SERC - Systems Engineering Research Center
				</div>
				<a href="<?php echo home_url() . "/privacy-policy/"; ?>" class="inline-block text-white hover:text-brand focus:outline-white">Privacy Policy</a>
			</div>
		</div>
	</div>
</footer>