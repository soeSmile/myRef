<template>
  <nav class="sm-nav">
    <div class="sm-nav-start">
      <span class="sm-fnt bold size-2">
        MyRef.top
      </span>
    </div>
    <div class="sm-nav-center"></div>
    <div class="sm-nav-end">
      <n-link to="/login"
              class="sm-nav-item">
        <i class='bx bx-exit'></i>
        <span class="sm-ml-2 sm-fnt light">
          {{ login }}
        </span>
      </n-link>

      <span class="sm-ml-1 sm-mr-1">|</span>

      <n-link to="/register"
              class="sm-nav-item">
        <i class='bx bxs-key'></i>
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
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>