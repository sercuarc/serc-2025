class Tabs {
  constructor(el) {
    console.log("Tabs initialized");

    this.container = el;
    this.tabs = this.container.querySelectorAll("[data-tab]");
    this.tabsContent = this.container.querySelectorAll("[data-tab-content]");
    this.tabs.forEach((tab) => {
      tab.addEventListener("click", (e) => {
        e.preventDefault();
        this.tabs.forEach((tab) => tab.classList.remove("is-active"));
        tab.classList.add("is-active");
        this.tabsContent.forEach((content) => {
          if (content.id === tab.getAttribute("href").substr(1)) {
            content.classList.add("is-active");
          } else {
            content.classList.remove("is-active");
          }
        });
      });
    });
  }
}

document.querySelectorAll("[data-tabs]").forEach((el) => new Tabs(el));
