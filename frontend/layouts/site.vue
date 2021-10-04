<template>
  <section class="sm-layout">

    <aside class="sm-layout-menu">
      Menu
    </aside>

    <section class="sm-layout-wrap">
      <header class="sm-layout-header">
        Head
      </header>

      <div class="sm-layout-content">
        Content
      </div>


      <footer class="sm-layout-footer">
        Footer
      </footer>
    </section>

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