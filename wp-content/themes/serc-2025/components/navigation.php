<?php $button_style = "gap-2 items-center font-medium hover:text-brand whitespace-nowrap cursor-pointer transition-colors"; ?>
<?php $menu_item_style = "border-b-4 border-transparent hover:border-brand pb-6"; ?>

<div data-navigation class="relative z-100 top-0 left-0 w-full">
	<header data-navigation-header class="group/header bg-white border-b border-subtle relative">
		<div class="flex items-center lg:items-end gap-6 xl:gap-16 px-6 xl:pr-12">
			<button data-navigation-menu-toggle class="group relative lg:hidden my-5 <?php echo $button_style; ?>">
				<span class="text-light-surface-subtle group-[.is-active]:opacity-0 group-[.is-active]:scale-0 transition-all"><?php serc_svg("menu", "size-6") ?></span>
				<span class="text-light-surface-normal translate-center opacity-0 scale-0 group-[.is-active]:opacity-100 group-[.is-active]:scale-100 transition-all"><?php serc_svg("close", "size-6") ?></span>
			</button>
			<a href="<?php echo home_url(); ?>" class="w-[152px] h-[40px] lg:w-[231px] lg:h-[62px] shrink-0 my-5">
				<img src="<?php echo get_template_directory_uri() . "/assets/logo-horz-color.svg"; ?>" alt="SERC Logo" width="231" height="62" class="w-full h-full object-contain">
			</a>
			<nav class="w-full flex items-start gap-6 xl:gap-16">
				<button class="<?php echo $button_style . ' ' . $menu_item_style; ?> hidden lg:flex">About <?php serc_svg("chevron-down", "size-4") ?></button>
				<button class="<?php echo $button_style . ' ' . $menu_item_style; ?> hidden lg:flex">Research <?php serc_svg("chevron-down", "size-4") ?></button>
				<button class="<?php echo $button_style . ' ' . $menu_item_style; ?> hidden lg:flex">Events &amp; News <?php serc_svg("chevron-down", "size-4") ?></button>
				<button class="<?php echo $button_style . ' ' . $menu_item_style; ?> hidden lg:flex">Resources &amp; Partners</button>
				<button class="<?php echo $button_style . ' ' . $menu_item_style; ?> hidden lg:flex">Contact</button>
				<button data-navigation-search-toggle class="<?php echo $button_style; ?> ml-auto flex gap-4">
					<span class="hidden lg:inline">Search</span>
					<?php serc_svg("search", "inline size-6 lg:size-5") ?>
				</button>
			</nav>
		</div>
		<form action="<?php echo home_url('/search'); ?>" data-search-ui class="
			absolute top-0 left-0 lg:left-[296px] right-0 h-full bg-white overflow-hidden transition-all
			px-6 xl:pr-12 flex items-center gap-4
			opacity-0 pointer-events-none
			group-[.is-searching]/header:opacity-100 group-[.is-searching]/header:pointer-events-auto
		">
			<span class="text-light-surface-subtle transition-transform translate-x-4 group-[.is-searching]/header:translate-x-0"><?php serc_svg("search", "size-6") ?></span>
			<label for="header-search-input" class="sr-only">Search topics, publications, and more</label>
			<input data-navigation-search-input type="text" name="query" id="header-search-input" class="w-full text-xl leading-none border-0 bg-transparent transition-transform translate-x-4 group-[.is-searching]/header:translate-x-0" placeholder="Search topics, publications, and more">
			<button type="button" data-navigation-search-toggle class="
				<?php echo $button_style; ?> 
				ml-auto text-light-surface-normal
				transition-transform translate-x-6 group-[.is-searching]/header:translate-x-0
				"><?php serc_svg("close", "size-6") ?></button>
			<button type="submit" class="sr-only">Submit</button>
		</form>
	</header>
	<div>
		<!-- dropdown menus here... -->
	</div>
</div>

<script type="text/javascript">
	(function() {
		class NavigationSearch {
			constructor(navigation) {
				if (!navigation) return;
				this.navigation = navigation;
				this.header = this.navigation.querySelector('[data-navigation-header]');
				this.searchInput = this.navigation.querySelector('[data-navigation-search-input]');
				this.toggles = this.navigation.querySelectorAll('[data-navigation-search-toggle]');
				this.init();
			}
			init() {
				this.toggles.forEach(toggle => {
					toggle.addEventListener('click', e => {
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

		class NavigationMenu {
			constructor(navigation) {
				if (!navigation) return;
				this.navigation = navigation;
				this.toggles = this.navigation.querySelectorAll('[data-navigation-menu-toggle]');
				this.init();
			}
			init() {
				this.toggles.forEach(toggle => {
					toggle.addEventListener('click', e => {
						e.preventDefault();
						toggle.classList.toggle('is-active');
					});
				})
			}
		}
		new NavigationMenu(document.querySelector('[data-navigation]'));
	})();
</script>