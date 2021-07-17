<template>
  <v-app>

    <site-head/>

    <v-main>
      <nuxt/>
    </v-main>

  </v-app>
</template>

<script>

import siteHead from "../components/site/siteHead";

export default {
  name: "auth",

  components: {
    siteHead,
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