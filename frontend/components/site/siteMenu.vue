<template>
  <nav class="sm-menu"
       :class="{ 'active' : show }">
    <div class="sm-flex middle sm-p-5"
         :class="show ? 'right' : 'center'">
      <i @click="show = !show"
         class="mdi mdi-menu sm-link sm-fnt size-4 sm-color-alert"></i>
    </div>

    <div v-if="$store.getters['auth/isAuth']">
      <div class="sm-menu-item sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-account'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ user.name }}
        </div>
      </div>

      <div @click="$store.dispatch('auth/logout')"
           class="sm-menu-item link sm-flex middle sm-link"
           :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-location-exit'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ allMenu.exit }}
        </div>
      </div>

      <div class="sm-line sm-m-2"></div>

      <div v-if="$store.getters['auth/isClient']"
           class="sm-bg-user-fon">

        <div v-for="val in userMenu" :key="val.name">
          <n-link v-if="val.link"
                  class="sm-menu-item sm-flex middle"
                  :class="show ? 'left' : 'center'"
                  :to="val.link">
            <div class="icon">
              <i :class="val.icon"></i>
            </div>
            <div class="text"
                 :class="{ 'active' : show }">
              {{ val.name }}
            </div>
          </n-link>
          <div v-else
               class="sm-menu-item link sm-flex middle sm-link"
               :class="show ? 'left' : 'center'">
            <div class="icon">
              <i :class="val.icon"></i>
            </div>
            <div class="text"
                 :class="{ 'active' : show }">
              {{ val.name }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <n-link to="/login"
              class="sm-menu-item link sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-login'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ allMenu.login }}
        </div>
      </n-link>

      <n-link to="/register"
              class="sm-menu-item link sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-key'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ allMenu.register }}
        </div>
      </n-link>
    </div>

    <div class="sm-line sm-m-2"></div>

    <n-link :to="val.link"
            v-for="val in menu"
            :key="val.name"
            :title="val.name"
            class="sm-menu-item link sm-flex middle"
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

  data() {
    return {
      show     : false,
      allMenu : {
        login   : 'Вход',
        register: 'Регистрация',
        exit    : 'Выход',
      },
      menu     : [
        {name: 'Главная', icon: 'mdi mdi-home', link: '/'},
        {name: 'Новинки', icon: 'mdi mdi-newspaper-variant', link: '/new'},
        {name: 'Категории', icon: 'mdi mdi-shape', link: '/category'},
        {name: 'Теги', icon: 'mdi mdi-tag-multiple', link: '/tags'},
        {name: 'Топ', icon: 'mdi mdi-arrow-up-bold', link: '/top'},
      ],
      userMenu: [
        {name: 'Добавить закладку', icon: 'mdi mdi-link', link: null},
        {name: 'Добавить заметку', icon: 'mdi mdi-note', link: null},
      ]
    }
  },

  computed: {
    user() {
      return this.$store.getters['auth/user'];
    }
  },
};
</script>