<template>
  <nav class="sm-menu">
    <div class="sm-menu-show"></div>
  </nav>
</template>

<script>
export default {
  name: "siteMenu",

  props: {},

  data() {
    return {
      login   : 'Вход',
      register: 'Регистрация',
      exit    : 'Выход',
      items   : [
        {name: 'Новинки', icon: '', link: ''},
        {name: 'Категории', icon: '', link: ''},
        {name: 'Теги', icon: '', link: ''},
        {name: 'Топ', icon: '', link: ''},
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