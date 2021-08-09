<template>
  <div class="sm-flex center wrap sm-mt-2">
    <tmpl-ref v-for="(val,key) in links" :key="key + 'ref'"
              :myRef="val"/>

    <ui-pagination :pagination="paginate" store="links/setUrl"/>
  </div>
</template>

<script>

import tmplRef from "../components/ref/tmplRef";
import uiPagination from "../components/ui/uiPagination";

export default {
  name: "index",

  layout: 'site',

  head: {
    title: 'Refs'
  },

  components: {
    tmplRef,
    uiPagination
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
    },
    paginate() {
      return this.$store.getters['links/paginate'];
    }
  },

  methods: {}
}
</script>