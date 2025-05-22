<?php
$post_name = get_post_field('post_name', get_queried_object_id());
$button_style = "gap-2 items-center font-medium hover:text-brand focus:text-brand whitespace-nowrap cursor-pointer transition-colors";
$menu_item_style = "border-b-4 border-transparent hover:border-brand focus:border-brand focus:text-brand pt-2 pb-6 focus:outline-0";
$featured_event = tribe_get_events([
	"posts_per_page" => 1,
	'start_date' => date('Y-m-d'),
]);
$menu_items = get_field('header_menus', 'options');
?>

<div data-navigation class="group/navigation fixed z-50 top-0 left-0 w-full">
	<header data-navigation-header class="group/header z-10 bg-white border-b border-subtle relative">
		<div class="flex items-center lg:items-end gap-6 lg:gap-16 px-6 xl:pr-12">
			<div class="relative lg:hidden my-5">
				<button data-navigation-close
					class="<?php echo $button_style; ?> translate-center opacity-0 scale-0 group-[.is-open]/navigation:opacity-100 group-[.is-open]/navigation:scale-100 transition-all text-light-surface-normal">
					<?php echo serc_svg("close", "size-6") ?>
				</button>
				<a data-navigation-menu-toggle href="#menu-mobile"
					class="<?php echo $button_style; ?> group-[.is-open]/navigation:opacity-0 group-[.is-open]/navigation:scale-0 group-[.is-open]/navigation:pointer-events-none transition-all text-light-surface-subtle">
					<?php echo serc_svg("menu", "size-6") ?>
				</a>
			</div>
			<a href="<?php echo home_url(); ?>" class="w-[152px] h-[40px] lg:w-[231px] lg:h-[62px] shrink-0 my-5">
				<img src="<?php echo get_template_directory_uri() . "/assets/images/logo-horz-color.svg"; ?>" alt="SERC Logo" width="231" height="62" class="w-full h-full object-contain">
			</a>
			<nav class="w-full flex items-start gap-6 xl:gap-16">
				<?php if ($menu_items) : ?>
					<?php foreach ($menu_items as $item) :
						$has_children = $item['display_as'] === 'parent';
						$slug = sanitize_title($item['label']);
						$class = ['group/menu-item hidden lg:flex', $button_style, $menu_item_style, $post_name == $slug ? '!border-brand !text-brand' : ''];
					?>
						<a <?php echo $has_children ? 'data-navigation-menu-hover-toggle' : '' ?>
							href="<?php echo $has_children ? "#menu-$slug" : $item['link'] ?>"
							class="<?php echo implode(' ', $class); ?>">
							<?php echo $item['label']; ?>
							<?php if ($has_children) : ?>
								<?php echo serc_svg("chevron-down", "size-4 transition-all group-[.is-active]/menu-item:rotate-180") ?>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
				<button data-navigation-search-toggle class="<?php echo $button_style; ?> ml-auto flex gap-4 lg:pt-2 lg:pb-7">
					<span class="hidden lg:inline">Search</span>
					<?php echo serc_svg("search", "inline size-6 lg:size-5") ?>
				</button>
			</nav>
		</div>
		<form action="<?php echo home_url('/search'); ?>" data-search-ui class="
			absolute top-0 left-0 lg:left-[296px] right-0 h-full bg-white overflow-hidden transition-all
			px-6 xl:pr-12 flex items-center gap-4
			opacity-0 pointer-events-none
			group-[.is-searching]/header:opacity-100 group-[.is-searching]/header:pointer-events-auto
		">
			<span class="text-light-surface-subtle transition-transform translate-x-4 group-[.is-searching]/header:translate-x-0"><?php echo serc_svg("search", "size-6") ?></span>
			<label for="header-search-input" class="sr-only">Search topics, publications, and more</label>
			<input data-navigation-search-input type="text" name="query" id="header-search-input" class="w-full text-xl leading-none border-0 outline-0 bg-transparent transition-transform translate-x-4 group-[.is-searching]/header:translate-x-0" placeholder="Enter search text">
			<button type="button" data-navigation-search-toggle class="
				<?php echo $button_style; ?> 
				ml-auto text-light-surface-normal
				transition-transform translate-x-6 group-[.is-searching]/header:translate-x-0
				"><?php echo serc_svg("close", "size-6") ?></button>
			<button type="submit" class="sr-only">Submit</button>
		</form>
	</header>
	<div
		data-navigation-menu-container
		class="
			absolute z-0 top-full left-0 w-full bg-white px-6 overflow-hidden transition-all
			h-[calc(100dvh-81px)] lg:h-0 
			pointer-events-none group-[.is-open]/navigation:pointer-events-auto
			opacity-0 group-[.is-open]/navigation:opacity-100
			-translate-x-12 lg:translate-x-0 group-[.is-open]/navigation:translate-x-0
			lg:-translate-y-12 group-[.is-open]/navigation:translate-y-0
			shadow-[0_16px_40px_16px_rgba(0,0,0,0.2)]
			duration-500
		">
		<nav data-navigation-menu
			id="menu-mobile"
			class="navigation-menu pt-16">
			<?php if ($menu_items) : ?>
				<?php foreach ($menu_items as $item) :
					$has_children = $item['display_as'] === 'parent';
					$slug = sanitize_title($item['label']);
				?>
					<a <?php echo $has_children ? 'data-navigation-menu-toggle' : '' ?>
						href="<?php echo $has_children ? '#menu-' . $slug : $item['link']; ?>"
						class="flex items-center gap-2 text-lg w-full leading-none p-5 cursor-pointer ">
						<?php echo $item['label']; ?>
						<?php if ($has_children) : ?>
							<?php echo serc_svg("chevron-down", "inline text-brand size-4 -rotate-90 ml-auto") ?>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</nav>
		<?php if ($menu_items) : ?>
			<?php
			$menus = array_filter($menu_items, fn($menu) => $menu["display_as"] === 'parent');
			$menus = array_map(function ($menu) {
				if ($menu["feature_display"] === "post") {
					$post_type = get_post_type_object(get_post_type($menu["featured_post"]));
					$label = "Featured " . $post_type->labels->singular_name;
					$icon = $post_type->labels->singular_name === "Event" ? "calendar" : "pin";
					$headline = ["text" => get_the_title($menu["featured_post"]), "label" => $label, "icon" => $icon];
					$cta = ["label" => "View " . $post_type->labels->singular_name, "url" => get_permalink($menu["featured_post"])];
				} else {
					$headline = ["text" => $menu["featured_text"], "label" => "", "icon" => ""];
					$cta = !empty($menu["featured_cta"]) ? ["label" => $menu["featured_cta"]["title"], "url" => $menu["featured_cta"]["url"]] : ["label" => "[Add a CTA]", "url" => "#"];
				}
				$items = array_map(fn($item) => ["label" => $item["link"]["title"], "url" => $item["link"]["url"]], $menu["items"]);
				return [
					"id" => sanitize_title($menu["label"]),
					"label" => $menu["label"],
					"items" => $items,
					"headline" => $headline,
					"cta" => $cta,
				];
			}, $menus); ?>
			<?php foreach ($menus as $menu) : ?>
				<nav data-navigation-menu
					id="menu-<?php echo $menu["id"]; ?>"
					class="navigation-menu sub-menu">
					<div class="lg:min-w-80 shrink-0">
						<a data-navigation-menu-toggle href="#menu-mobile" class="relative flex items-center gap-4 text-h4 leading-none p-5 cursor-pointer lg:hidden">
							<?php echo serc_svg("chevron-left", "absolute top-1/2 -left-1 -translate-y-1/2 size-4"); ?>
							<?php echo $menu["label"]; ?>
						</a>
						<div class="hidden lg:block text-h6 leading-none text-light-surface-subtle mt-2 mb-6">In This Section:</div>
						<?php
						foreach ($menu["items"] as $item) : ?>
							<a
								href="<?php echo $item["url"]; ?>"
								class="
							flex items-center gap-2 text-lg w-full leading-none p-5 cursor-pointer transition-colors outline-0
							lg:border-l-2 lg:border-transparent hover:border-brand focus:border-brand
							hover:text-brand focus:text-brand
							hover:font-semibold focus:font-semibold
							hover:bg-light-secondary focus:bg-light-secondary
						">
								<?php echo $item["label"]; ?>
								<?php echo serc_svg("arrow-right", "inline text-brand size-4 lg:hidden") ?>
							</a>
						<?php endforeach; ?>
					</div>
					<div class="border-subtle lg:w-0 lg:h-full lg:border-l"></div>
					<a href="<?php echo $menu["cta"]["url"]; ?>" class="group flex flex-col gap-8 lg:pt-2 lg:max-w-[630px]">
						<?php if ($menu["headline"]["label"]) : ?>
							<div class="flex gap-1 items-center">
								<?php if ($menu["headline"]["icon"]) : ?>
									<?php echo serc_svg("calendar", "text-brand size-5") ?>
								<?php endif; ?>
								<span class="uppercase text-light-surface-muted"><?php echo $menu["headline"]["label"] ?></span>
							</div>
						<?php endif; ?>
						<p class="text-xl lg:text-h4 group-hover:text-brand group-focus:text-brand"><?php echo $menu["headline"]["text"] ?></p>
						<p class="font-medium lg:text-xl">
							<div class="group-hover:text-brand group-focus:text-brand transition-colors inline-flex items-center gap-2 font-medium">
								<span><?php echo $menu["cta"]["label"]; ?></span>
								<?php echo serc_svg("arrow-right", "group-hover:translate-x-2 transition-transform text-brand size-5") ?>
							</div>
						</p>
					</a>
				</nav>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>