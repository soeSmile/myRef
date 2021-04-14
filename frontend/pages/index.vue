<template>
  <v-container>
    <div class="sm-flex center wrap">
      <tmpl-ref v-for="n in 22"/>
    </div>
  </v-container>
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