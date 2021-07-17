<template>
  <nav class="sm-nav">
    <div class="sm-nav-start">
      <span class="sm-fnt bold size-2">
        MyRef.top
      </span>
    </div>
    <div class="sm-nav-center"></div>

    <div v-if="isAuth"
         class="sm-nav-end">
      <div class="sm-nav-item sm-link sm-hover-color-3">
        <i class='bx bx-user'></i>
        <span class="sm-ml-2 sm-fnt light">
          {{ user.name }}
        </span>
      </div>

      <span class="sm-ml-1 sm-mr-1">|</span>

      <div class="sm-nav-item sm-link sm-hover-color-3"
           @click="$store.dispatch('auth/logout')">
        <i class='mdi mdi-user'></i>
        <span class="sm-ml-2 sm-fnt light">
          {{ exit }}
        </span>
      </div>
    </div>

    <div v-else
         class="sm-nav-end">
      <n-link to="/login"
              class="sm-nav-item sm-hover-color-3">
        <i class='mdi mdi-login'></i>
        <span class="sm-ml-2 sm-fnt light">
          {{ login }}
        </span>
      </n-link>

      <span class="sm-ml-1 sm-mr-1">|</span>

      <n-link to="/register"
              class="sm-nav-item sm-hover-color-3">
        <i class='mdi mdi-key'></i>
        <span class="sm-ml-2 sm-fnt light">
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