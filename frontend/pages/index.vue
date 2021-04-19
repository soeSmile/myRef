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