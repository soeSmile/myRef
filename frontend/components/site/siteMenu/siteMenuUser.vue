<template>
  <section>

    <div v-for="val in menu" :key="val.name">
      <n-link v-if="val.link"
              class="sm-menu-item sm-flex middle"
              :class="show ? 'left' : 'center'"
              :to="val.link">
        <div class="icon">
          <i :class="val.icon"></i>
        </div>
        <div class="text"
             :class="{ 'active' : show }">
          {{ val.name }}
        </div>
      </n-link>
      <div v-else
           class="sm-menu-item link sm-flex middle sm-link"
           :class="show ? 'left' : 'center'">
        <div class="icon">
          <i :class="val.icon"></i>
        </div>
        <div class="text"
             :class="{ 'active' : show }">
          {{ val.name }}
        </div>
      </div>
    </div>

  </section>
</template>

<script>
export default {
  name: "siteMenuUser",

  props: {
    show: false
  },

  data() {
    return {
      menu: [
        {name: 'Добавить закладку', icon: 'mdi mdi-link', link: null},
        {name: 'Добавить заметку', icon: 'mdi mdi-note', link: null},
      ]
    };
  },

  computed: {},

  watch: {},

  created() {
  },

  mounted() {
  },

  methods: {},
};
</script>