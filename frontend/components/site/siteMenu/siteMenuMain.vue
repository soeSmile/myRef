<template>
  <section>
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
  </section>
</template>

<script>
export default {
  name: "siteMenuMain",

  props: {
    show: false
  },

  data() {
    return {
      menu: [
        {name: 'Главная', icon: 'mdi mdi-home', link: '/'},
        {name: 'Новинки', icon: 'mdi mdi-newspaper-variant', link: '/new'},
        {name: 'Категории', icon: 'mdi mdi-shape', link: '/category'},
        {name: 'Теги', icon: 'mdi mdi-tag-multiple', link: '/tags'},
        {name: 'Топ', icon: 'mdi mdi-arrow-up-bold', link: '/top'},
      ],
    };
  },
};
</script>