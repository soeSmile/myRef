<template>
  <section class="sm-layout">
    <header class="sm-layout-header sm-bg-color-1 sm-p-4">
      <nav class="sm-nav">
        <div class="sm-nav-start"></div>
        <div class="sm-nav-center"></div>
        <div class="sm-nav-end sm-color-white">
          <n-link :to="isAdmin ? '/admin' : '/'"
                  class="sm-nav-item sm-link sm-hover-color-7">
            <i class='mdi mdi-account'></i>
            <span class="sm-ml-2 sm-fnt light sm-hide-mobile">
              {{ user.name }}
            </span>
          </n-link>
          <span class="sm-ml-1 sm-mr-1">|</span>
          <div class="sm-nav-item sm-link sm-hover-color-7"
               @click="$store.dispatch('auth/logout')">
            <i class='mdi mdi-location-exit'></i>
            <span class="sm-ml-2 sm-fnt light sm-hide-mobile">
              Exit
            </span>
          </div>
        </div>
      </nav>
    </header>
    <section class="sm-layout-content sm-flex">
      <div class="sm-wpx-250 sm-h-100 sm-bg-smoke">
        <nav class="sm-flex col sm-p-2">
          <n-link :to="val.link"
                  exact-active-class="sm-admin-active"
                  class="sm-flex row middle sm-p-4 sm-hover-bg-color-9 sm-hover-white"
                  v-for="(val,key) in menus" :key="key">
            <i class="sm-mr-2 mdi " :class="val.icon"></i>
            <span>{{ val.name }}</span>
          </n-link>
        </nav>
      </div>

      <div class="sm-flex col sm-h-100 sm-w-100 sm-p-4">
        <nuxt/>
      </div>
    </section>

    <footer class="sm-layout-footer sm-bg-color-1 sm-p-4"></footer>
  </section>
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