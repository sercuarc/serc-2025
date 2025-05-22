const SELECTION_EVENT = navigator.maxTouchPoints > 0 ? "touchend" : "click";
const BREAKPOINT_LG = 1024;

class NavigationSearch {
  constructor(navigation) {
    if (!navigation) return console.error("No navigation found :(");
    this.navigation = navigation;
    this.header = this.navigation.querySelector("[data-navigation-header]");
    this.searchInput = this.navigation.querySelector(
      "[data-navigation-search-input]"
    );
    this.toggles = this.navigation.querySelectorAll(
      "[data-navigation-search-toggle]"
    );
    this.init();
  }
  init() {
    this.toggles.forEach((toggle) => {
      toggle.addEventListener(SELECTION_EVENT, (e) => {
        e.preventDefault();
        this.header.classList.toggle("is-searching");
        setTimeout(() => {
          this.searchInput.focus();
        }, 500);
      });
    });
  }
}
new NavigationSearch(document.querySelector("[data-navigation]"));

/** ------------------------------------- */

class NavigationMenu {
  constructor(navigation) {
    if (!navigation) return console.error("No navigation found :(");
    this.navigation = navigation;
    this.navMenuContainer = this.navigation.querySelector(
      "[data-navigation-menu-container]"
    );
    this.menuHoverToggles = this.navigation.querySelectorAll(
      "[data-navigation-menu-hover-toggle]"
    );
    this.menuToggles = this.navigation.querySelectorAll(
      "[data-navigation-menu-toggle], [data-navigation-mobile-toggle]"
    );
    this.closeBtn = this.navigation.querySelector("[data-navigation-close]");
    this.menus = this.navigation.querySelectorAll("[data-navigation-menu]");
    this.menuActionTimeout = 0;
    this._data = new Proxy(
      {
        activeMenu: "",
      },
      {
        set: (target, prop, value) => {
          if (prop === "activeMenu") {
            this.onActiveMenuChange(value);
          }
          target[prop] = value;
          return true;
        },
      }
    );
    this.init();
  }
  set activeMenu(value) {
    this._data.activeMenu = value;
  }
  get activeMenu() {
    return this._data.activeMenu;
  }
  init() {
    this.menuToggles.forEach((menuToggle) => {
      menuToggle.addEventListener(SELECTION_EVENT, (e) => {
        e.preventDefault();
        this.menus.forEach((menu) => {
          if (menu.classList.contains("is-active")) {
            this.closeMenu(menu);
          }
        });
        if (!this.navIsOpen()) this.openNav();
        this.openMenu(menuToggle.getAttribute("href"));
      });
    });

    this.menuHoverToggles.forEach((hoverToggle) => {
      const selector = hoverToggle.getAttribute("href");

      hoverToggle.addEventListener("click", (e) => e.preventDefault());

      hoverToggle.addEventListener("mouseenter", (e) => {
        clearTimeout(this.menuActionTimeout);
        hoverToggle.focus();
        if (this.activeMenu !== selector) this.closeMenu(this.activeMenu);
        this.activeMenu = selector;
        const menu = this.__getMenu(selector);
        this.openNav(menu.offsetHeight + "px");
        this.openMenu(menu);
      });

      hoverToggle.addEventListener("mouseleave", (e) => {
        hoverToggle.blur();
        this.menuActionTimeout = setTimeout(() => {
          this.closeNav();
        }, 300);
      });
    });

    this.navMenuContainer.addEventListener("mouseenter", (e) => {
      clearTimeout(this.menuActionTimeout);
    });

    this.navMenuContainer.addEventListener("mouseleave", (e) => {
      this.menuActionTimeout = setTimeout(() => {
        this.closeNav();
      }, 500);
    });

    this.closeBtn.addEventListener(SELECTION_EVENT, (e) => {
      e.preventDefault();
      this.menus.forEach((menu) => {
        this.closeMenu(menu);
      });
      this.closeNav();
    });
  }
  onActiveMenuChange(activeMenuHash) {
    const currentActive = this.navigation.querySelectorAll(
      "[data-navigation-menu-hover-toggle].is-active"
    );
    const current = this.navigation.querySelector(
      '[data-navigation-menu-hover-toggle][href="' + activeMenuHash + '"]'
    );
    if (!activeMenuHash || currentActive.length) {
      currentActive.forEach((c) =>
        c.classList.remove("is-active", "text-brand")
      );
    }
    if (current) {
      current.classList.add("is-active", "text-brand");
    }
  }
  navIsOpen() {
    return this.navigation.classList.contains("is-open");
  }
  openNav(height) {
    if (window.innerWidth >= BREAKPOINT_LG) {
      this.navMenuContainer.style.height = height;
    }
    this.navigation.classList.add("is-open");
  }
  closeNav() {
    this.activeMenu = "";
    this.navigation.classList.remove("is-open");
    if (window.innerWidth >= BREAKPOINT_LG) {
      this.navMenuContainer.style.height = "0px";
    }
  }
  openMenu(menu) {
    menu = this.__getMenu(menu);
    if (!menu) return;
    menu.classList.add("is-active");
  }
  closeMenu(menu) {
    if (!menu) return;
    menu = this.__getMenu(menu);
    if (!menu) return;
    menu.classList.remove("is-active");
  }
  __getMenu(menu) {
    let selector;
    if (typeof menu === "string") {
      if (menu[0] !== "#") {
        selector = "#" + menu;
      } else {
        selector = menu;
      }
      menu = this.navigation.querySelector(selector);
    }
    if (menu instanceof Element === false) {
      console.error("No menu found :(", {
        menu,
        selector,
      });
    }
    return menu;
  }
}
new NavigationMenu(document.querySelector("[data-navigation]"));
