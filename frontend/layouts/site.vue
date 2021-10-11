<template>
  <section class="sm-layout">

    <aside class="sm-layout-menu">
      <site-menu/>
    </aside>

    <section class="sm-layout-wrap">
      <header class="sm-layout-header">
        <site-search-head/>
      </header>

      <div class="sm-layout-content">
        <nuxt/>
      </div>


      <footer class="sm-layout-footer">
        Footer
      </footer>
    </section>

  </section>
</template>

<script>

import siteMenu from "../components/site/siteMenu";
import SiteSearchHead from "../components/site/head/siteSearchHead";

export default {
  name: "site",

  components: {
    SiteSearchHead,
    siteMenu
  },

  data() {
    return {}
  }
}
</script>