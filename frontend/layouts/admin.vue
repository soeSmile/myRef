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

      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <!--  -->
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "admin",

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
        {name: 'Настройки', icon: 'mdi-cogs', link: ''},
        {name: 'Категории', icon: 'mdi-shape', link: ''},
        {name: 'Теги', icon: 'mdi-tag-multiple', link: ''},
        {name: 'Пользователи', icon: 'mdi-account-supervisor', link: ''},
      ]
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>