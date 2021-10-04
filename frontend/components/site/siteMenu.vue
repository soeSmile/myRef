<template>
  <nav class="sm-menu"
       :class="{ 'active' : show }">
    <div class="sm-flex sm-p-4"
         :class="show ? 'right' : 'center'">
      <i @click="show = !show"
         class="mdi mdi-menu sm-link sm-fnt size-4 sm-color-sm-orange"></i>
    </div>

    <n-link :to="val.link"
            v-for="val in items"
            :key="val.name"
            :title="val.name"
            class="sm-menu-item sm-flex middle"
            :class="show ? 'left' : 'center'">
      <div class="sm-menu-icon">
        <i :class="val.icon"></i>
      </div>
      <div class="sm-menu-text"
           :class="{ 'active' : show }">
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
      login   : 'Вход',
      register: 'Регистрация',
      exit    : 'Выход',
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