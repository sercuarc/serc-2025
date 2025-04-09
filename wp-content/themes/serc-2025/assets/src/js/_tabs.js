class Tabs {
  constructor(el) {
    this.container = el;
    this.tabs = this.container.querySelectorAll("[data-tab]");
    this.tabsContent = this.container.querySelectorAll("[data-tab-content]");
    this.init();
  }
  init() {
    const search = new URLSearchParams(window.location.search);
    const activeTab = search.get("tab");
    console.log(activeTab);
    console.log(this);

    if (activeTab) {
      this.openTab(
        this.container.querySelector(`[data-tab][href="#${activeTab}"]`)
      );
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
    history.pushState(null, "", `?tab=${tab.getAttribute("href").substr(1)}`);
    this.tabsContent.forEach((content) => {
      if (content.id === tab.getAttribute("href").substr(1)) {
        content.classList.add("is-active");
      } else {
        content.classList.remove("is-active");
      }
    });
  }
}

document.querySelectorAll("[data-tabs]").forEach((el) => new Tabs(el));
