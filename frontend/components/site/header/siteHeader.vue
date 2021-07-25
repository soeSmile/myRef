<template>
  <nav class="sm-nav">
    <div class="sm-nav-start">
      <div v-if="$route.path === '/'"
           class="sm-nav-item sm-link sm-hover-color-7 sm-show-mobile">
        <i class='mdi mdi-menu'></i>
      </div>
      <div class="sm-nav-item">
      <span class="sm-fnt bold size-2">
        <n-link to="/"
                class="sm-nav-item sm-hover-color-7">
          MyRef.top
        </n-link>
      </span>
      </div>
    </div>
    <div class="sm-nav-center"></div>

    <div v-if="isAuth"
         class="sm-nav-end">
      <div class="sm-nav-item sm-link sm-hover-color-7">
        <i class='mdi mdi-account'></i>
        <span class="sm-ml-2 sm-fnt light sm-hide-mobile">
          {{ user.name }}
        </span>
      </div>

      <span class="sm-ml-1 sm-mr-1">|</span>

      <div class="sm-nav-item sm-link sm-hover-color-7"
           @click="$store.dispatch('auth/logout')">
        <i class='mdi mdi-location-exit'></i>
        <span class="sm-ml-2 sm-fnt light sm-hide-mobile">
          {{ exit }}
        </span>
      </div>
    </div>

    <div v-else
         class="sm-nav-end">
      <n-link to="/login"
              class="sm-nav-item sm-hover-color-7">
        <i class='mdi mdi-login'></i>
        <span class="sm-ml-2 sm-fnt light sm-hide-mobile">
          {{ login }}
        </span>
      </n-link>

      <span class="sm-ml-1 sm-mr-1">|</span>

      <n-link to="/register"
              class="sm-nav-item sm-hover-color-7">
        <i class='mdi mdi-key'></i>
        <span class="sm-ml-2 sm-fnt light sm-hide-mobile">
          {{ register }}
        </span>
      </n-link>
    </div>

  </nav>
</template>

<script>
export default {
  name: "siteHeader",

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      login   : 'Вход',
      register: 'Регистрация',
      exit    : 'Выход'
    }
  },

  computed: {
    user() {
      return this.$store.getters['auth/user'];
    }
  },
}
</script>