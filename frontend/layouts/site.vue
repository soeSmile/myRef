<template>
  <section class="sm-layout">

    <aside class="sm-layout-menu">
      <site-menu/>
      <search-menu/>
    </aside>

    <section class="sm-layout-wrap">
      <header class="sm-layout-header"></header>

      <div class="sm-layout-content">
        <nuxt/>
      </div>


      <footer class="sm-layout-footer"></footer>
    </section>

  </section>
</template>

<script>

import SiteMenu from "../components/site/siteMenu";
import SearchMenu from "../components/site/searchMenu";

export default {
  name: "site",

  components: {
    SiteMenu,
    SearchMenu
  },

  data() {
    return {}
  },
}
</script>