<template>
  <div class="sm-flex center wrap mt-2">
    <tmpl-ref v-for="(val,key) in links" :key="key + 'ref'"
              :myRef="val"/>

    <div class="text-center mt-2">
      <v-pagination v-if="Object.keys(paginate).length > 0"
                    v-model="page"
                    @input="paginateMove"
                    :total-visible="10"
                    :length="paginate.last_page"/>
    </div>
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
    },
    paginate() {
      return this.$store.getters['links/paginate'];
    },
    page: {
      get() {
        return this.$store.getters['links/current']
      },
      set(value) {
        this.$store.commit('links/SET_CURRENT', value)
      }
    }
  },

  watch: {},

  methods: {
    /**
     * @param val
     */
    paginateMove(val) {
      let query = this.$route.query
      query.page = val

      this.$store.dispatch('links/setUrl', {params: query})
    }
  }
}
</script>