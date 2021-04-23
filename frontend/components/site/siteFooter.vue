<template>
  <v-footer padless fixed color="white">
    <v-col class="text-center" cols="12">
      {{ new Date().getFullYear() }} — <strong>myRef.top</strong>
    </v-col>
  </v-footer>
</template>

<script>
export default {
  name: "siteFooter",

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