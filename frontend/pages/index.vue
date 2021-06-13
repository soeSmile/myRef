<template>
  <div class="sm-flex center wrap mt-2">
    <tmpl-ref v-for="(val,key) in links" :key="key + 'ref'"
              :myRef="val"
    />
  </div>
</template>

<script>

import tmplRef from "../components/ref/tmplRef";

export default {
  name: "index",

  layout: 'site',

  components: {
    tmplRef
  },

  created() {
    this.$store.dispatch('links/setUrl', {params: this.$route.query})
  },

  data() {
    return {}
  },

  computed: {
    links() {
      return this.$store.getters['links/links'];
    }
  },

  watch: {},

  methods: {}
}
</script>