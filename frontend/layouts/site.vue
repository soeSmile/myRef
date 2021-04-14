<template>
  <v-app>
    <v-app-bar app flat>

      <v-tabs centered
              color="grey darken-1">
        <v-tab v-for="link in links" :key="link">
          {{ link }}
        </v-tab>
      </v-tabs>

      <v-spacer></v-spacer>

      <v-avatar class="hidden-sm-and-down"
                color="grey darken-1 shrink"
                size="32"/>
    </v-app-bar>

    <v-main>
      <nuxt/>
    </v-main>

    <v-footer padless>
      <v-col class="text-center" cols="12">
        {{ new Date().getFullYear() }} — <strong>myRef.top</strong>
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: "site",

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      links: [
        'Dashboard',
        'Messages',
        'Profile',
        'Updates',
      ],
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>