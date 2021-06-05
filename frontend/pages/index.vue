<template>
  <div class="sm-flex center wrap mt-2">
    <tmpl-ref v-for="(val,key) in links" :key="key + 'ref'"
              :url="val.url"
              :title="val.title"
              :desc="val.desc"
              :img="val.img"
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

  props: {},

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