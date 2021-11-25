<template>
  <section>
    <div class="sm-p-6 sm-w-30">
      <b-field>
        <b-input placeholder="Поиск категории"
                 v-model="search"
                 type="search"
                 icon="magnify"
                 icon-right="close-circle"
                 icon-right-clickable
                 @icon-right-click="search = ''">
        </b-input>
      </b-field>
    </div>

    <div class="sm-flex wrap sm-p-2">
      <n-link :to="'/?type=3&cats=['+val.id+']'"
              v-for="val in categories"
              :key="val.id"
              class="card sm-wpx-300 sm-m-4">
        <div class="card-content">
          <div class="content sm-flex col center middle">
            <i class="sm-color-alert mdi mdi-48px"
               :class="val.icon"></i>
            <p class="sm-color-link sm-fnt bold sm-mt-4">
              {{ val.name }}
            </p>
          </div>
        </div>
      </n-link>
    </div>
  </section>
</template>

<script>
export default {
  name: "category",

  layout: 'site',

  props: {},

  data() {
    return {
      search  : '',
      paginate: {}
    };
  },

  computed: {
    /**
     * @return {array}
     */
    categories() {
      return this.$store.getters['category/categories'];
    },
  }
};
</script>