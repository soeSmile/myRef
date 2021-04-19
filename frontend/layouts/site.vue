<template>
  <v-app>

    <siteHead/>

    <v-main class="grey lighten-3">
      <div class="layout-main-container">
        <div class="sm-flex wrap">
          <div class="layout-left">
            <site-user-block/>
            <site-search/>
          </div>
          <div class="layout-content">
            <nuxt/>
          </div>
        </div>
      </div>
    </v-main>

    <v-footer padless fixed>
      <v-col class="text-center" cols="12">
        {{ new Date().getFullYear() }} — <strong>myRef.top</strong>
      </v-col>
    </v-footer>

    <add-ref :dialog="dialog"/>
  </v-app>
</template>

<script>

import addRef from "../components/ref/addRef";
import siteHead from "../components/site/siteHead";
import SiteSearch from "../components/site/siteSearch";
import siteUserBlock from "../components/site/siteUserBlock";

export default {
  name: "site",

  components: {
    SiteSearch,
    addRef,
    siteHead,
    siteUserBlock
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