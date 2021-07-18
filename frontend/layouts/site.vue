<template>
  <section class="sm-layout">
    <header class="sm-layout-header sm-bg-color-1 sm-color-white sm-p-4">
      <div class="sm-container center">
        <site-header/>
      </div>
    </header>

    <section class="sm-layout-content">
      <div class="sm-container center sm-flex row">
        <div class="sm-w-25">
          <site-search/>
        </div>
        <div class="sm-w-75 sm-flex col sm-pl-2">
          <div>
            <site-control/>
          </div>
          <div>

          </div>
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