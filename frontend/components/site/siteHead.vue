<template>
  <v-app-bar app dark color="blue darken-1">
    <div class="layout-main-container sm-flex middle">

      <v-toolbar-title class="mr-4">
        MyRef.top
      </v-toolbar-title>

      <v-btn dark text
             v-for="(val,key) in menu" :key="val + key">
        <v-icon left>{{ val.icon }}</v-icon>
        {{ val.text }}
      </v-btn>

      <v-spacer/>

      <v-btn color="amber" class="mx-2" disabled>
        <v-icon left dark>
          mdi-plus
        </v-icon>
        Заметку
      </v-btn>

      <v-btn color="teal" class="mx-2" disabled>
        <v-icon left dark>
          mdi-plus
        </v-icon>
        Ссылку
      </v-btn>

      <v-menu offset-y
              v-if="isAuth">
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
        <v-btn text class="mx-2">
          <v-icon left dark>
            mdi-logout-variant
          </v-icon>
          Выход
        </v-btn>
      </v-menu>

      <div v-else>
        <v-btn text class="mx-2" nuxt to="login">
          <v-icon left dark>
            mdi-login-variant
          </v-icon>
          Вход
        </v-btn>
        <v-btn text class="mx-2" nuxt to="register">
          <v-icon left dark>
            mdi-account-plus-outline
          </v-icon>
          Регистрация
        </v-btn>
      </div>

      <n-link to="/" class="ml-4">
        <v-avatar>
          <img src="/logo.svg" alt="logo">
        </v-avatar>
      </n-link>

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