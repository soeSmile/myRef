<template>
  <v-app>

    <site-head/>

    <v-main>
      <div class="layout-main-container">
        <nuxt/>
      </div>
    </v-main>

    <site-footer/>

  </v-app>
</template>

<script>

import siteHead from "../components/site/siteHead";
import siteFooter from "../components/site/siteFooter";

export default {
  name: "auth",

  components: {
    siteHead,
    siteFooter
  },

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {}
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>