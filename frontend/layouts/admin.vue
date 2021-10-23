<template>
  <section class="sm-layout">

    <aside class="sm-layout-menu">
      <nav class="sm-menu"
           :class="{ 'active' : show }">
        <div class="sm-flex middle sm-p-5"
             :class="show ? 'right' : 'center'">
          <i @click="show = !show"
             class="mdi mdi-menu sm-link sm-fnt size-4 sm-color-alert"></i>
        </div>

        <n-link :to="val.link"
                v-for="val in menu"
                :key="val.name"
                :title="val.name"
                class="sm-menu-item link sm-flex middle"
                :class="show ? 'left' : 'center'"
                :exact="val.exact">
          <div class="icon">
            <i :class="val.icon"></i>
          </div>
          <div class="text" :class="{ 'active' : show }">
            {{ val.name }}
          </div>
        </n-link>
      </nav>
    </aside>

    <section class="sm-layout-wrap">
      <header class="sm-layout-header"></header>

      <div class="sm-layout-content">
        <nuxt/>
      </div>


      <footer class="sm-layout-footer"></footer>
    </section>

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
      show: false,
      menu: [
        {name: 'Главная', icon: 'mdi mdi-home', link: '/', exact: true},
        {name: 'Настройки', icon: 'mdi mdi-cogs', link: '/admin/setting', exact: false},
        {name: 'Ссылки', icon: 'mdi mdi-link', link: '/admin/link', exact: false},
        {name: 'Категории', icon: 'mdi mdi-shape', link: '/admin/category', exact: false},
        {name: 'Теги', icon: 'mdi mdi-tag-multiple', link: '/admin/tag', exact: false},
        {name: 'Пользователи', icon: 'mdi mdi-account-supervisor', link: '/admin/user', exact: false},
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