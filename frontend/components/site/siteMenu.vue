<template>
  <nav class="sm-menu sm-bg-white"
       :class="{ 'active' : show }">
    <div class="sm-flex sm-p-4"
         :class="show ? 'right' : 'center'">
      <i @click="show = !show"
         class="mdi mdi-menu sm-link sm-fnt size-4 sm-color-sm-orange"></i>
    </div>

    <n-link :to="val.link"
            v-for="val in items"
            :key="val.name"
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
        {name: 'Новинки', icon: 'mdi mdi-newspaper-variant', link: ''},
        {name: 'Категории', icon: 'mdi mdi-shape', link: ''},
        {name: 'Теги', icon: 'mdi mdi-tag-multiple', link: ''},
        {name: 'Топ', icon: 'mdi mdi-arrow-up-bold', link: ''},
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