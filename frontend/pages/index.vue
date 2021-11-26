<template>
  <section>
    <div class="sm-flex wrap sm-p-2">
      <tmpl-ref v-for="(val,key) in links" :key="key + 'ref'"
                :myRef="val"/>
    </div>

    <ui-pagination :pagination="paginate" store="links/setUrl"/>
  </section>
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

  data() {
    return {}
  },

  watch: {
    '$route.query'(to, from) {
      this.$store.dispatch('links/getLinks', to)
    }
  },

  computed: {
    links() {
      return this.$store.getters['links/links'];
    },
    paginate() {
      return this.$store.getters['links/paginate'];
    }
  },

  created() {
    this.$store.dispatch('links/getLinks', this.$route.query)
  },
}
</script>