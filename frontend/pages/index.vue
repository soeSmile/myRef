<template>
  <div class="sm-flex center wrap mt-2">
    <tmpl-ref v-for="(val,key) in links" :key="key + 'ref'"
              :myRef="val"/>

    <v-pagination v-if="Object.keys(paginate).length > 0"
                  v-model="page"
                  @input="paginateMove"
                  :length="paginate.last_page"/>
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
    return {
      page: 1
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

  watch: {},

  methods: {
    /**
     * @param val
     */
    paginateMove(val) {
      let query = Object.assign(this.$route.query, {page: val})
      this.$store.dispatch('links/setUrl', {params: query})
    }
  }
}
</script>