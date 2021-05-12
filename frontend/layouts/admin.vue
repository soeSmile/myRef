<template>
  <v-app id="inspire">
    <v-navigation-drawer
        v-model="drawer"
        app>
      <v-list dense nav>
        <v-list-item v-for="item in menus"
                     :key="item.name"
                     nuxt
                     :to="item.link">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"/>

      <v-toolbar-title>Admin Panel</v-toolbar-title>

      <v-spacer/>

      <v-btn text class="mx-2">
        <v-icon left dark>
          mdi-account
        </v-icon>
        {{ user.name }}
      </v-btn>
      <v-btn text class="mx-2"
             @click="$store.dispatch('auth/logout')">
        <v-icon left dark>
          mdi-login-variant
        </v-icon>
        Вход
      </v-btn>

    </v-app-bar>

    <v-main>
      <div class="pa-4">
        <nuxt/>
      </div>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "admin",

  middleware: ['auth', 'authAdmin'],

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      drawer: true,
      menus : [
        {name: 'Главная', icon: 'mdi-home', link: '/'},
        {name: 'Настройки', icon: 'mdi-cogs', link: '/admin/setting'},
        {name: 'Ссылки', icon: 'mdi-link', link: '/admin/link'},
        {name: 'Категории', icon: 'mdi-shape', link: '/admin/category'},
        {name: 'Теги', icon: 'mdi-tag-multiple', link: '/admin/tag'},
        {name: 'Пользователи', icon: 'mdi-account-supervisor', link: '/admin/user'},
      ]
    }
  },

  computed: {
    user() {
      return this.$store.getters['auth/user'];
    }
  },

  watch: {},

  methods: {}
}
</script>