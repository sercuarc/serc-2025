<?php

/**
 * Template Name: People Landing
 */
?>

<?php get_header(); ?>

<main>
	<header class="hero <?php if ($thumbnail) : ?>hero--inverted hero--with-image<?php endif; ?>">
		<?php if ($image = null) : ?>
			<?php echo $image; ?>
		<?php endif; ?>
		<div class="container">
			<h1 class="text-h1">People</h1>
		</div>
	</header>
	<section class="bg-white pt-12 lg:pt-16 pb-20 lg:pb-30">
		<div class="container">

			<div data-tabs>
				<nav class="tab-menu flex gap-0 overflow-y-hidden overflow-x-auto">
					<a data-tab href="#operations" class="tab is-active">Operations</a>
					<a data-tab href="#research-council" class="tab">Research Council</a>
					<a data-tab href="#advisory-council" class="tab">Advisory Council</a>
				</nav>
				<div class="tab-content-wrapper">
					<div data-tab-content id="operations" class="tab-content is-active mt-20 lg:mt-30">
						<h2 class="text-title-1 text-center">Leadership</h2>
						<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-12 lg:mt-20 -mx-4">
							<?php for ($i = 0; $i < 4; $i++) : ?>
								<a href="#" class="group/person-card-lg flex flex-col sm:flex-row gap-8 p-4 bg-white hover:shadow-lg focus:shadow-lg outline-0 transition-all">
									<div class="mx-auto sm:mx-0"><?php get_template_part("components/avatar-placeholder") ?></div>
									<div class="flex flex-col gap-6 text-center sm:text-left">
										<h3 class="text-h4 leading-none text-light-surface-strong group-hover/person-card-lg:text-brand transition-colors">Person Name</h3>
										<p class="label-base text-light-surface-strong">SERC Executive Director</p>
										<p class="text-xs leading-none uppercase text-light-surface-normal">
											<?php echo serc_svg("institution", "inline text-brand size-3 mr-1"); ?>
											Stevens Institute Of Technology
										</p>
									</div>
								</a>
							<?php endfor; ?>
						</div>
					</div>
					<div data-tab-content id="research-council" class="tab-content mt-20 lg:mt-30">
						<h2 class="text-title-1 text-center">Research Council</h2>
						<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-12 lg:mt-20 -mx-4">
							<?php for ($i = 0; $i < 4; $i++) : ?>
								<a href="#" class="group/person-card-lg flex flex-col sm:flex-row gap-8 p-4 bg-white hover:shadow-lg focus:shadow-lg outline-0 transition-all">
									<div class="mx-auto sm:mx-0"><?php get_template_part("components/avatar-placeholder") ?></div>
									<div class="flex flex-col gap-6 text-center sm:text-left">
										<h3 class="text-h4 leading-none text-light-surface-strong group-hover/person-card-lg:text-brand transition-colors">Person Name</h3>
										<p class="label-base text-light-surface-strong">SERC Executive Director</p>
										<p class="text-xs leading-none uppercase text-light-surface-normal">
											<?php echo serc_svg("institution", "inline text-brand size-3 mr-1"); ?>
											Stevens Institute Of Technology
										</p>
									</div>
								</a>
							<?php endfor; ?>
						</div>
					</div>
					<div data-tab-content id="advisory-council" class="tab-content mt-20 lg:mt-30">
						<h2 class="text-title-1 text-center">Advisory Council</h2>
						<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-12 lg:mt-20 -mx-4">
							<?php for ($i = 0; $i < 4; $i++) : ?>
								<a href="#" class="group/person-card-lg flex flex-col sm:flex-row gap-8 p-4 bg-white hover:shadow-lg focus:shadow-lg outline-0 transition-all">
									<div class="mx-auto sm:mx-0"><?php get_template_part("components/avatar-placeholder") ?></div>
									<div class="flex flex-col gap-6 text-center sm:text-left">
										<h3 class="text-h4 leading-none text-light-surface-strong group-hover/person-card-lg:text-brand transition-colors">Person Name</h3>
										<p class="label-base text-light-surface-strong">SERC Executive Director</p>
										<p class="text-xs leading-none uppercase text-light-surface-normal">
											<?php echo serc_svg("institution", "inline text-brand size-3 mr-1"); ?>
											Stevens Institute Of Technology
										</p>
									</div>
								</a>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>


		</div>
	</section>
	<section class="bg-light-tertiary py-20 lg:py-30">
		<div class="container">
			<h2 class="text-title-1 text-center">Staff</h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-12 lg:mt-20">
				<?php for ($i = 0; $i < 15; $i++) : ?>
					<div class="group/person-card-lg flex flex-col sm:flex-row gap-8">
						<div class="flex flex-col gap-6 text-center sm:text-left">
							<h3 class="text-h4 leading-none text-light-surface-strong transition-colors">Person Name</h3>
							<p class="label-base text-light-surface-strong">SERC Executive Director</p>
							<p class="text-xs leading-none uppercase text-light-surface-normal">
								<?php echo serc_svg("institution", "inline text-brand size-3 mr-1"); ?>
								Stevens Institute Of Technology
							</p>
						</div>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>