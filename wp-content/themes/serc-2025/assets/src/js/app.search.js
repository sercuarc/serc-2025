const { createApp, ref } = Vue;

function data() {
  return {
    searchQuery: SEARCH_APP.searchQuery,
    filters: SEARCH_APP.filters,
    status: "idle",
    results: [],
  };
}

const computed = {
  recentYears() {
    const currentYear = new Date().getFullYear();
    return Array.from({ length: 20 }, (_, i) => currentYear - i);
  },
};

const methods = {
  handleSearch(e) {
    const formData = new FormData(e.target);
    for (const [key, val] of formData.entries()) {
      console.log(key, val);
    }
    this.status = "loading";
    setTimeout(() => {
      this.status = "idle";
    }, 2000);
  },
};

createApp({ data, computed, methods }).mount("#app-search");
