<template>
  <section class="sm-layout">

    <aside class="sm-layout-menu">
      <site-menu/>
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

import siteMenu from "../components/site/siteMenu";

export default {
  name: "site",

  components: {
    siteMenu
  },

  data() {
    return {}
  }
}
</script>