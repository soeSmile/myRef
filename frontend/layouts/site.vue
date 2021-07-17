<template>
  <section class="sm-layout">
    <header class="sm-layout-header sm-bg-color-1 sm-color-white sm-p-4">
      <div class="sm-container center">
        <site-header/>
      </div>
    </header>

    <section class="sm-layout-content">
      <aside></aside>
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

export default {
  name: "site",

  components: {
    siteHeader,
    siteFooter
  },

  data() {
    return {}
  }
}
</script>