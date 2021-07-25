<template>
  <section class="sm-layout">
    <header class="sm-layout-header sm-bg-color-1 sm-color-white sm-p-4">
      <div class="sm-container center">
        <site-header/>
      </div>
    </header>

    <section class="sm-layout-content">
      <div class="sm-container center sm-flex row sm-h-100">
        <div class="sm-search-block sm-h-100">
          <site-search/>
        </div>
        <div class="sm-list-block sm-flex col sm-h-100">
          <site-control/>
          <nuxt/>
        </div>
      </div>
    </section>

    <footer class="sm-layout-footer sm-bg-color-1 sm-color-white">
      <div class="sm-container center">
        <site-footer/>
      </div>
    </footer>
  </section>
</template>

<script>

import siteHeader from "../components/site/header/siteHeader";
import siteFooter from "../components/site/footer/siteFooter";
import siteSearch from "../components/site/search/siteSearch";
import siteControl from "../components/site/control/siteControl";

export default {
  name: "site",

  components: {
    siteHeader,
    siteFooter,
    siteSearch,
    siteControl
  },

  data() {
    return {}
  }
}
</script>