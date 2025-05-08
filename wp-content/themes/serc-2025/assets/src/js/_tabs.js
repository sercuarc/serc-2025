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

    this.tabs.forEach((tab) => {
      tab.addEventListener("click", (e) => {
        e.preventDefault();
        this.openTab(tab);
      });
    });
  }

  openTab(tab) {
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
