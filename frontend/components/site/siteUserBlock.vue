<template>
  <v-card class="mt-4">
    <v-card-title>
      Бок пользователя
    </v-card-title>

    <v-list-group :value="false" no-action sub-group>
      <template v-slot:activator>
        <v-list-item-title>Категории</v-list-item-title>
      </template>

      <v-list-item nuxt exact
                   :to="{ name: '', query: { cat: val.id }}"
                   @click="request"
                   v-for="(val,key) in categories" :key="key">
        <v-list-item-title v-text="val.name"></v-list-item-title>
      </v-list-item>
    </v-list-group>
  </v-card>
</template>

<script>
export default {
  name: "siteUserBlock",

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {}
  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  watch: {},

  methods: {
    request() {
      this.$store.dispatch('links/setUrl', {params: this.$route.query})
    }
  }
}
</script>