<template>
  <v-app>
    <v-app-bar app flat>
      <v-app-bar-nav-icon/>
      <v-toolbar-title>Page title</v-toolbar-title>

      <v-text-field flat
                    hide-details
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    class="ma-4"
                    clearable
                    append-outer-icon="mdi-send"
                    solo
                    @click:append-outer="search"/>

      <v-btn text>
        <v-icon left>mdi-account</v-icon>
        User Name
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-login-variant</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-logout-variant</v-icon>
      </v-btn>

      <template v-slot:extension>
        <v-tabs centered
                color="grey darken-1">
          <v-tab v-for="link in links" :key="link">
            {{ link }}
          </v-tab>
        </v-tabs>
      </template>
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

  methods: {
    search() {
    }
  }
}
</script>