<template>
  <div class="sm-flex center wrap mt-2">
    <tmpl-ref v-for="n in 22" :key="n + 'ref'"/>
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

  asyncData(ctx) {
  },

  props: {},

  data() {
    return {}
  },

  computed: {},

  watch: {
    '$route.query': function (val) {
      console.log(val)
    }
  },

  methods: {}
}
</script>