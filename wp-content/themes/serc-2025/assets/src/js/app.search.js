const { createApp } = Vue;

const STATUS_IDLE = "idle";
const STATUS_LOADING = "loading";
const STATUS_ERROR = "error";
const perPage = 20;

function delay(ms = 500) {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, ms);
  });
}

function data() {
  return {
    status: STATUS_IDLE,
    query: SEARCH_APP.query,
    doc_types: [],
    exact: false,
    year: "all",
    sort: "_score",
    page: 1,
    pages: { total: 1, current: 1 },
    totalDocs: 0,
    maxPages: 4,
    docsQuery: "",
    docs: [],
  };
}

const computed = {
  pagingLinks() {
    const links = [];
    const start = Math.max(1, this.page - this.maxPages);
    const end = Math.min(this.pages.total, this.page + this.maxPages);
    for (let i = start; i <= end; i++) {
      links.push(i);
    }
    return links;
  },
  recentYears() {
    const currentYear = new Date().getFullYear();
    return Array.from({ length: 20 }, (_, i) => currentYear - i);
  },
  docsOffsetStart() {
    return (this.page - 1) * perPage + 1;
  },
  docsOffsetEnd() {
    return Math.min(this.page * perPage, this.totalDocs);
  },
};

const watch = {
  page() {
    this.handleSearch();
  },
};

const methods = {
  resetQuery() {
    this.query = "";
    this.$refs.queryInput.focus();
  },

  async setPage(page) {
    this.scrollToTop(this.$refs.resultsContainer.offsetTop);
    await delay(1000);
    this.page = page;
  },

  scrollToTop(top = 0) {
    const navHeight = document.querySelector("[data-navigation]").offsetHeight;
    window.scrollTo({
      top: Math.max(0, top - navHeight),
      behavior: "smooth",
    });
  },

  toggleDocType(type) {
    if (this.doc_types.includes(type)) {
      this.doc_types = this.doc_types.type((f) => f !== type);
    } else {
      this.doc_types.push(type);
    }
  },

  truncate(str, wordCount = 50) {
    if (!str) return "";
    const words = str.split(" ");
    return (
      words.slice(0, wordCount).join(" ") +
      (words.length > wordCount ? " ..." : "")
    );
  },

  formatDate(unixDate) {
    const date = new Date(unixDate * 1000);
    return date.toLocaleDateString("en-US", {
      year: "numeric",
      month: "long",
      day: "numeric",
    });
  },

  async handleSearch() {
    const response = await this.search();
    if (response.error) {
      this.status = STATUS_ERROR;
      return console.error(response.error);
    }
    this.totalDocs = response.docs.hits.total.value;
    this.docs = response.docs.hits.hits.map((hit) => hit._source);
    this.docsQuery = response.params.query;
    this.pages = response.pages;
  },

  async search() {
    const data = {
      query: this.query,
      doc_types: this.doc_types.join(","),
      exact: this.exact,
      year: this.year,
      sort: this.sort,
      page: this.page,
    };
    this.status = STATUS_LOADING;
    let response;
    try {
      response = await fetch("/wp-json/serc-2025/v1/search", {
        body: JSON.stringify(data),
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });
      const json = await response.json();
      response = json;
    } catch (error) {
      console.error("Error fetching search results: ", error);
      response = { error: error.message };
    }
    this.status = STATUS_IDLE;
    return response;
  },
};

function mounted() {
  if (this.query) {
    this.handleSearch();
  }
}

createApp({
  name: "AppSearch",
  data,
  computed,
  watch,
  methods,
  mounted,
}).mount("#app-search");
