<template>
  <v-app-bar app dark color="blue darken-4">
    <div class="layout-main-container sm-flex middle">

      <n-link to="/">
        <v-avatar class="mr-4"
                  color="grey darken-1"
                  size="32"/>
      </n-link>

      <v-toolbar-title class="mx-6">
        MyRef.top
      </v-toolbar-title>

      <v-btn dark text
             v-for="(val,key) in menu" :key="val + key">
        <v-icon left>{{ val.icon }}</v-icon>
        {{ val.text }}
      </v-btn>

      <v-spacer/>

      <v-btn color="amber" class="mx-4">
        Добавить заметку
        <v-icon right dark>
          mdi-plus
        </v-icon>
      </v-btn>

      <v-btn color="teal" class="mx-4">
        Добавить закладку
        <v-icon right dark>
          mdi-plus
        </v-icon>
      </v-btn>

      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn dark text
                 v-bind="attrs"
                 v-on="on">
            <v-icon left>mdi-account</v-icon>
            User Name
          </v-btn>
        </template>

        <v-list dense>
          <v-list-item-group color="primary">
            <v-list-item class="mx-2"
                         nuxt
                         :to="val.link"
                         v-for="(val, i) in userMenu" :key="i">
              <v-list-item-icon>
                <v-icon v-text="val.icon"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="val.text"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </v-menu>

    </div>
  </v-app-bar>
</template>

<script>
export default {
  name: "siteHead",

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      menu    : [
        {text: 'Топ', icon: 'mdi-clock', link: 'search'},
        {text: 'Новые', icon: 'mdi-account', link: 'search'},
      ],
      userMenu: [
        {text: 'Real-Time', icon: 'mdi-clock', link: 'search'},
        {text: 'Audience', icon: 'mdi-account', link: 'search'},
        {text: 'Conversions', icon: 'mdi-flag', link: 'search'},
      ],
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>