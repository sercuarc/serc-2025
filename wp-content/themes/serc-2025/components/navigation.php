<?php
global $post;
$post->post_name;
$button_style = "gap-2 items-center font-medium hover:text-brand focus:text-brand whitespace-nowrap cursor-pointer transition-colors";
$menu_item_style = "border-b-4 border-transparent hover:border-brand focus:border-brand focus:text-brand pt-2 pb-6 focus:outline-0";
$menu_items = [
	"about" => ["label" => "About", "has_children" => "chevron-down"],
	"research" => ["label" => "Research", "has_children" => "chevron-down"],
	"events-news" => ["label" => "Events & News", "has_children" => "chevron-down"],
	"resources-partners" => ["label" => "Resources & Partners", "has_children" => false],
	"contact" => ["label" => "Contact", "has_children" => false],
];
$featured_event = tribe_get_events([
	"posts_per_page" => 1,
	'start_date' => date('Y-m-d'),
])
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
				<?php foreach ($menu_items as $id => $item) : ?>
					<a <?php if ($item["has_children"]) : ?>data-navigation-menu-hover-toggle<?php endif; ?>
						href="<?php if ($item["has_children"]) {
										echo "#menu-$id";
									} else {
										echo home_url($id);
									} ?>"
						class="
							group/menu-item hidden lg:flex 
							<?php echo $button_style . ' ' . $menu_item_style; ?>
							<?php if (strpos($id, $post->post_name) !== false) : ?>
								!border-brand !text-brand
							<?php endif; ?>
						">
						<?php echo $item["label"]; ?>
						<?php if ($item["has_children"]) : ?>
							<?php echo serc_svg("chevron-down", "size-4 transition-all group-[.is-active]/menu-item:rotate-180") ?>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
				<button data-navigation-search-toggle class="<?php echo $button_style; ?> ml-auto flex gap-4">
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
			<?php foreach ($menu_items as $id => $item) : ?>
				<a data-navigation-menu-toggle href="#menu-<?php echo $id; ?>" class="flex items-center gap-2 text-lg w-full leading-none p-5 cursor-pointer ">
					<?php echo $item["label"]; ?>
					<?php if ($item["has_children"]) : ?>
						<?php echo serc_svg("chevron-down", "inline text-brand size-4 -rotate-90 ml-auto") ?>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</nav>
		<?php
		$menus = [
			[
				"id" => "about",
				"label" => "About",
				"items" => [['label' => 'About SERC', 'url' => home_url('about')], ['label' => 'People', 'url' => home_url('people')]],
				"headline" => [
					"label" => "",
					"icon" => "",
					"text" => "Discover how we can help your research efforts with our national network of experts."
				],
				"cta" => ["label" => "Learn More About What We Do", "url" => "#"],
			],
			[
				"id" => "research",
				"label" => "Research",
				"items" => [['label' => 'Our Research', 'url' => home_url('research')], ['label' => 'Publications', 'url' => home_url('publications')]],
				"headline" => [
					"label" => "",
					"icon" => "",
					"text" => "Discover how our Research Roadmaps for our mission areas of Velocity, Security, and AI/Autonomy can impact the success or your organization's campaigns."
				],
				"cta" => ["label" => "View Our Research Roadmaps", "url" => "#"],
			],
			[
				"id" => "events-news",
				"label" => "Events & News",
				"items" => [['label' => 'Events', 'url' => home_url('events')], ['label' => 'SERC Research Review', 'url' => '#'], ['label' => 'AI4SE & SE4AI Workshop', 'url' => '#'], ['label' => 'News', 'url' => home_url('news')]],
				"headline" => [
					"label" => "Featured Event",
					"icon" => "calendar",
					"text" => get_the_title($featured_event[0]->ID)
				],
				"cta" => ["label" => "View Event", "url" => get_permalink($featured_event[0]->ID)],
			],
		]; ?>
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
				<div class="flex flex-col gap-8 lg:pt-2 lg:max-w-[630px]">
					<?php if ($menu["headline"]["label"]) : ?>
						<div class="flex gap-1 items-center">
							<?php if ($menu["headline"]["icon"]) : ?>
								<?php echo serc_svg("calendar", "text-brand size-5") ?>
							<?php endif; ?>
							<span class="uppercase text-light-surface-muted"><?php echo $menu["headline"]["label"] ?></span>
						</div>
					<?php endif; ?>
					<p class="text-xl lg:text-h4"><?php echo $menu["headline"]["text"] ?></p>
					<p class="font-medium lg:text-xl">
						<a href="<?php echo $menu["cta"]["url"]; ?>" class="group hover:text-brand transition-colors">
							<?php echo $menu["cta"]["label"]; ?>
							<?php echo serc_svg("arrow-right", "group-hover:translate-x-2 transition-transform inline text-brand size-4 ml-2") ?>
						</a>
					</p>
				</div>
			</nav>
		<?php endforeach; ?>
	</div>
</div>

<script type="text/javascript">
	(function() {
		const SELECTION_EVENT = navigator.maxTouchPoints > 0 ? 'touchend' : 'click';
		const BREAKPOINT_LG = 1024;

		class NavigationSearch {
			constructor(navigation) {
				if (!navigation) return console.error("No navigation found :(");
				this.navigation = navigation;
				this.header = this.navigation.querySelector('[data-navigation-header]');
				this.searchInput = this.navigation.querySelector('[data-navigation-search-input]');
				this.toggles = this.navigation.querySelectorAll('[data-navigation-search-toggle]');
				this.init();
			}
			init() {
				this.toggles.forEach(toggle => {
					toggle.addEventListener(SELECTION_EVENT, e => {
						e.preventDefault();
						this.header.classList.toggle('is-searching')
						setTimeout(() => {
							this.searchInput.focus();
						}, 500)
					});
				});
			}
		}
		new NavigationSearch(document.querySelector('[data-navigation]'));


		/** ------------------------------------- */


		class NavigationMenu {
			constructor(navigation) {
				if (!navigation) return console.error("No navigation found :(");
				this.navigation = navigation;
				this.navMenuContainer = this.navigation.querySelector('[data-navigation-menu-container]');
				this.menuHoverToggles = this.navigation.querySelectorAll('[data-navigation-menu-hover-toggle]');
				this.menuToggles = this.navigation.querySelectorAll('[data-navigation-menu-toggle], [data-navigation-mobile-toggle]');
				this.closeBtn = this.navigation.querySelector('[data-navigation-close]');
				this.menus = this.navigation.querySelectorAll('[data-navigation-menu]');
				this.menuActionTimeout = 0
				this._data = new Proxy({
					activeMenu: '',
				}, {
					set: (target, prop, value) => {
						if (prop === "activeMenu") {
							this.onActiveMenuChange(value);
						}
						target[prop] = value;
						return true;
					},
				});
				this.init();
			}
			set activeMenu(value) {
				this._data.activeMenu = value;
			}
			get activeMenu() {
				return this._data.activeMenu;
			}
			init() {

				this.menuToggles.forEach(menuToggle => {
					menuToggle.addEventListener(SELECTION_EVENT, e => {
						e.preventDefault();
						this.menus.forEach(menu => {
							if (menu.classList.contains('is-active')) {
								this.closeMenu(menu);
							}
						})
						if (!this.navIsOpen()) this.openNav();
						this.openMenu(menuToggle.getAttribute('href'));
					});
				});

				this.menuHoverToggles.forEach(hoverToggle => {
					const selector = hoverToggle.getAttribute('href');

					hoverToggle.addEventListener('click', e => e.preventDefault());

					hoverToggle.addEventListener('mouseenter', e => {
						clearTimeout(this.menuActionTimeout);
						hoverToggle.focus();
						if (this.activeMenu !== selector) this.closeMenu(this.activeMenu);
						this.activeMenu = selector;
						const menu = this.__getMenu(selector);
						this.openNav(menu.offsetHeight + 'px');
						setTimeout(() => {
							this.openMenu(menu);
						}, 500)
					});

					hoverToggle.addEventListener('mouseleave', e => {
						hoverToggle.blur();
						this.menuActionTimeout = setTimeout(() => {
							this.closeMenu(this.activeMenu);
							this.closeNav();
						}, 500)
					});

				})

				this.navMenuContainer.addEventListener('mouseenter', e => {
					clearTimeout(this.menuActionTimeout);
				});

				this.navMenuContainer.addEventListener('mouseleave', e => {
					this.menuActionTimeout = setTimeout(() => {
						this.closeNav()
					}, 500)
				});

				this.closeBtn.addEventListener(SELECTION_EVENT, e => {
					e.preventDefault();
					this.menus.forEach(menu => {
						this.closeMenu(menu);
					})
					this.closeNav();
				});

			}
			onActiveMenuChange(activeMenuHash) {
				const currentActive = this.navigation.querySelectorAll('[data-navigation-menu-hover-toggle].is-active');
				const current = this.navigation.querySelector('[data-navigation-menu-hover-toggle][href="' + activeMenuHash + '"]');
				if (!activeMenuHash || currentActive.length) {
					currentActive.forEach(c => c.classList.remove('is-active', 'text-brand'));
				}
				if (current) {
					current.classList.add('is-active', 'text-brand');
				}
			}
			navIsOpen() {
				return this.navigation.classList.contains('is-open');
			}
			openNav(height) {
				if (window.innerWidth >= BREAKPOINT_LG) {
					this.navMenuContainer.style.height = height;
				}
				this.navigation.classList.add('is-open');
			}
			closeNav() {
				this.activeMenu = '';
				this.navigation.classList.remove('is-open');
				if (window.innerWidth >= BREAKPOINT_LG) {
					this.navMenuContainer.style.height = '0px';
				}
			}
			openMenu(menu) {
				menu = this.__getMenu(menu);
				if (!menu) return
				menu.classList.add('is-active');
			}
			closeMenu(menu) {
				if (!menu) return
				menu = this.__getMenu(menu);
				if (!menu) return
				menu.classList.remove('is-active');
			}
			__getMenu(menu) {
				let selector
				if (typeof menu === 'string') {
					if (menu[0] !== '#') {
						selector = '#' + menu;
					} else {
						selector = menu;
					}
					menu = this.navigation.querySelector(selector);
				}
				if (menu instanceof Element === false) {
					console.error("No menu found :(", {
						menu,
						selector
					});
				}
				return menu;
			}
		}
		new NavigationMenu(document.querySelector('[data-navigation]'));
	})();
</script>