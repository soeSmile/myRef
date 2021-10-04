<template>
  <nav class="sm-menu"
       :class="{ 'active' : show }">
    <div class="sm-flex sm-p-4"
         :class="show ? 'right' : 'center'">
      <i @click="show = !show"
         class="mdi mdi-menu sm-link sm-fnt size-4 sm-color-sm-orange"></i>
    </div>

    <div v-if="$store.getters['auth/isAuth']">
      <n-link :to="$store.getters['auth/isAdmin'] ? '/admin' : '/'"
              class="sm-menu-item sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-account'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ user.name }}
        </div>
      </n-link>

      <div @click="$store.dispatch('auth/logout')"
           class="sm-menu-item sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi location-exit'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ userMenu.exit }}
        </div>
      </div>
    </div>
    <div v-else>
      <n-link to="/login"
              class="sm-menu-item sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-login'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ userMenu.login }}
        </div>
      </n-link>

      <n-link to="/register"
              class="sm-menu-item sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-key'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ userMenu.register }}
        </div>
      </n-link>
    </div>

    <div class="sm-line sm-m-2"></div>

    <n-link :to="val.link"
            v-for="val in items"
            :key="val.name"
            :title="val.name"
            class="sm-menu-item sm-flex middle"
            :class="show ? 'left' : 'center'">
      <div class="icon">
        <i :class="val.icon"></i>
      </div>
      <div class="text" :class="{ 'active' : show }">
        {{ val.name }}
      </div>
    </n-link>

  </nav>
</template>

<script>
export default {
  name: "siteMenu",

  props: {},

  data() {
    return {
      show    : true,
      userMenu: {
        login   : 'Вход',
        register: 'Регистрация',
        exit    : 'Выход',
      },
      items   : [
        {name: 'Главная', icon: 'mdi mdi-home', link: '/'},
        {name: 'Новинки', icon: 'mdi mdi-newspaper-variant', link: '/new'},
        {name: 'Категории', icon: 'mdi mdi-shape', link: '/category'},
        {name: 'Теги', icon: 'mdi mdi-tag-multiple', link: '/tags'},
        {name: 'Топ', icon: 'mdi mdi-arrow-up-bold', link: '/top'},
      ]
    }
  },

  computed: {
    user() {
      return this.$store.getters['auth/user'];
    }
  },

  watch: {},

  created() {
  },

  mounted() {
  },

  methods: {},
};
</script>