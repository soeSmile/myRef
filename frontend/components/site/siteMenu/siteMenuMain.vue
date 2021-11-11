<template>
  <section>
    <div class="sm-line sm-m-2"></div>

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
        {name: 'Главная', icon: 'mdi mdi-home', link: '/', exact: true},
        {name: 'Категории', icon: 'mdi mdi-shape', link: '/category', exact: false},
        {name: 'Теги', icon: 'mdi mdi-tag-multiple', link: '/tags', exact: false},
        {name: 'Топ', icon: 'mdi mdi-arrow-up-bold', link: '/top', exact: false},
      ],
    };
  },
};
</script>