<template>
  <v-app>

    <site-head/>

    <v-main>
      <div class="layout-main-container">
        <div class="sm-flex wrap">
          <div class="layout-left">
            <site-user-block v-if="isAuth"/>
            <site-search/>
          </div>
          <div class="layout-content">
            <nuxt/>
          </div>
        </div>
      </div>
    </v-main>

    <site-footer/>

    <add-ref :dialog="dialog"/>
  </v-app>
</template>

<script>

import addRef from "../components/ref/addRef";
import siteHead from "../components/site/siteHead";
import SiteSearch from "../components/site/siteSearch";
import siteUserBlock from "../components/site/siteUserBlock";
import siteFooter from "../components/site/siteFooter";

export default {
  name: "site",

  components: {
    SiteSearch,
    addRef,
    siteHead,
    siteUserBlock,
    siteFooter
  },

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      dialog        : {
        show: false
      },
      loading       : false,
      selectCategory: null,
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>