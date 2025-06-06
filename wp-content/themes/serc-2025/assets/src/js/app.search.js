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

function getQueryParam(name) {
  const searchParams = new URLSearchParams(window.location.search);
  return searchParams.get(name);
}

function data() {
  return {
    status: STATUS_IDLE,
    query: getQueryParam("query") || SEARCH_APP.query,
    doc_type_options: {
      "events-news": "Events / News",
      media: "Media",
      people: "People",
      publications: "Publications",
      other: "Other",
    },
    defaultQueries: [
      "Mission Aware Security",
      "Digital Engineering Transformation",
      "Model-Centric Engineering",
      "Adaptive Cyber-Physical-Human Systems",
      "Human Capital Development",
      "Systems of Systems",
      "Systems Engineering Cost Estimation",
      "Systems Engineering Risk Analysis",
      "Systems Resilience",
    ],
    doc_types: getQueryParam("doc_types")
      ? getQueryParam("doc_types").split(",")
      : [],
    exact: getQueryParam("exact") === "true" ? true : false,
    year: getQueryParam("year") || "all",
    sort: getQueryParam("sort") || "_score",
    page: getQueryParam("page") || 1,
    pages: { total: 1, current: 1 },
    totalDocs: 0,
    maxVisiblePages: 3,
    docsQuery: "",
    docs: [],
  };
}

const computed = {
  pagingLinks() {
    const links = [];
    const start = Math.max(1, this.page - this.maxVisiblePages);
    const end = Math.min(this.pages.total, this.page + this.maxVisiblePages);
    for (let i = start; i <= end; i++) {
      links.push(i);
    }
    return links;
  },
  recentYears() {
    const startYear = 2008;
    const currentYear = new Date().getFullYear();
    // Get an array of years from now back to startYear
    return Array.from(
      { length: currentYear - startYear + 1 },
      (_, i) => currentYear - i
    );
  },
  docsOffsetStart() {
    return (this.page - 1) * perPage + 1;
  },
  docsOffsetEnd() {
    return Math.min(this.page * perPage, this.totalDocs);
  },
};

const watch = {
  exact() {
    this.page = 1;
    this.search();
  },
  page() {
    this.search();
  },
  sort() {
    this.page = 1;
    this.search();
  },
  year() {
    this.page = 1;
    this.search();
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
      this.doc_types = this.doc_types.filter((f) => f !== type);
    } else {
      this.doc_types.push(type);
    }
    this.page = 1;
    this.search();
  },

  getDocumentUrl(doc) {
    switch (doc.type) {
      case "News":
      case "Event":
      case "People":
        return doc.url;
      case "Technical Report":
        return `/documents/technical-reports/${doc.id}`;
      default:
        return `/documents/publications/${doc.id}`;
    }
  },

  getDocumentDate(doc) {
    let dateString = "";
    switch (doc.type) {
      case "News":
      case "Event":
        return doc.date_formatted;
      case "People":
      case "Organizations":
        dateString = "";
      default:
        dateString = doc.publication_date || doc.start_date || doc.created_at;
    }
    if (!dateString) {
      return "";
    }
    const date = new Date(dateString);
    if (isNaN(date.getTime())) {
      return dateString;
    } else {
      return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
      });
    }
  },

  formateDocTypesString(doc_type_ids) {
    const doc_types = doc_type_ids.map((t) => this.doc_type_options[t]);
    if (doc_types.length > 1) {
      return `${doc_types.slice(0, doc_types.length - 1).join(", ")} or ${
        doc_types[doc_types.length - 1]
      }`;
    } else {
      return doc_types[0];
    }
  },

  async handleSearchSubmit() {
    this.page = 1;
    return await this.search();
  },

  async search(params) {
    // Build the data object for our request
    const data = {
      query: this.query,
      doc_types: this.doc_types.join(","),
      exact: this.exact,
      year: this.year,
      sort: this.sort,
      page: this.page,
      ...params,
    };

    // Prepare to fetch
    this.status = STATUS_LOADING;
    let response;

    try {
      // Make the request
      response = await fetch("/wp-json/serc-2025/v1/search", {
        body: JSON.stringify(data),
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });
      // Process the response
      const json = await response.json();
      response = json;
      // Update URL with new query params
      this.updateUrl();
    } catch (error) {
      console.error("Error fetching search results: ", error);
      response = { error: error.message };
    }

    // Handle errors
    if (response.error) {
      this.status = STATUS_ERROR;
      return console.error(response.error);
    }

    // Update state
    this.totalDocs = response.totalDocs;
    this.docs = response.docs;
    this.docsQuery = response.params.query;
    this.pages = response.pages;
    this.status = STATUS_IDLE;

    return response;
  },

  updateUrl() {
    // update page URL
    const queryString = new URLSearchParams({
      query: this.query,
      doc_types: this.doc_types.join(","),
      exact: this.exact,
      year: this.year,
      sort: this.sort,
      page: this.page,
    }).toString();
    history.pushState(null, "", `?${queryString}`);
  },
};

function mounted() {
  if (this.query || this.doc_types.length > 0) {
    this.search();
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
