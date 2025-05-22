class Tabs {
  constructor(el) {
    this.container = el;
    this.options = {
      pushState: false,
    };
    if (this.container.dataset.tabs) {
      try {
        const instanceOptions = JSON.parse(this.container.dataset.tabs);
        this.options = { ...this.options, ...instanceOptions };
      } catch (e) {
        console.error("Couldn't parse Tabs options.");
        console.error(e);
      }
    }
    this.tabMenu = this.container.querySelector("[data-tab-menu]");
    this.tabMenuToggle = this.container.querySelector("[data-tab-menu-toggle]");
    this.tabMenuToggleText = this.container.querySelector(
      "[data-tab-menu-toggle-text]"
    );
    this.tabs = this.container.querySelectorAll("[data-tab]");
    this.tabsContent = this.container.querySelectorAll("[data-tab-content]");
    this.init();
  }
  init() {
    if (this.options.pushState === true) {
      const search = new URLSearchParams(window.location.search);
      const activeTab = search.get("tab");
      if (activeTab) {
        this.openTab(
          this.container.querySelector(`[data-tab][href="#${activeTab}"]`)
        );
      }
    }

    this.tabMenuToggle.addEventListener("click", (e) => {
      e.preventDefault();
      this.tabMenu.classList.toggle("is-open");
    });

    this.tabs.forEach((tab) => {
      tab.addEventListener("click", (e) => {
        if (tab.getAttribute("href").indexOf("#") !== 0) return;
        e.preventDefault();
        this.openTab(tab);
      });
    });

    document.addEventListener("click", (e) => {
      if (!this.tabMenu.contains(e.target)) {
        this.tabMenu.classList.remove("is-open");
      }
    });
  }

  openTab(tab) {
    this.tabMenu.classList.remove("is-open");
    this.tabMenuToggleText.textContent = tab.textContent;
    this.tabs.forEach((tab) => tab.classList.remove("is-active"));
    tab.classList.add("is-active");
    this.tabsContent.forEach((content) => {
      if (content.id === tab.getAttribute("href").substr(1)) {
        content.classList.add("is-active");
      } else {
        content.classList.remove("is-active");
      }
    });
    if (this.options.pushState === true) {
      history.pushState(null, "", `?tab=${tab.getAttribute("href").substr(1)}`);
    }
  }
}

document.querySelectorAll("[data-tabs]").forEach((el) => new Tabs(el));
