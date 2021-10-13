<template>
  <section>

    <n-link v-for="val in menu"
            :key="val.name"
            :to="val.link"
            class="sm-menu-item link sm-flex middle"
            :class="show ? 'left' : 'center'">
      <div class="icon">
        <i :class="val.icon"></i>
      </div>
      <div class="text"
           :class="{ 'active' : show }">
        {{ val.name }}
      </div>
    </n-link>

  </section>
</template>

<script>
export default {
  name: "siteMenuAuth",

  props: {
    show: false
  },

  data() {
    return {
      menu: [
        {name: 'Вход', icon: 'mdi mdi-login', link: '/login'},
        {name: 'Регистрация', icon: 'mdi mdi-key', link: '/register'},
      ],
    };
  },
};
</script>