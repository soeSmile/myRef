<template>
  <section class="sm-layout">
    <header class="sm-layout-header sm-bg-color-1 sm-color-white sm-p-4">
      <div class="sm-container center">
        <site-header/>
      </div>
    </header>
    <section class="sm-layout-content">
      Content
    </section>
    <footer class="sm-layout-footer">
      Footer
    </footer>
  </section>
</template>

<script>

import siteHeader from "../components/site/header/siteHeader";

export default {
  name: "site",

  components: {
    siteHeader
  },

  data() {
    return {}
  }
}
</script>