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
                   :to="{ name: '', query: { category: val.id }}"
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
    return {
      categories: [
        {id: 1, name: 'Новости', icon: 'mdi-home'},
        {id: 2, name: 'Наука', icon: 'mdi-home'},
        {id: 3, name: 'Техника', icon: 'mdi-home'},
        {id: 4, name: 'Бизнес и Работа', icon: 'mdi-home'},
        {id: 5, name: 'Образование', icon: 'mdi-home'},
        {id: 6, name: 'Медицина', icon: 'mdi-home'},
        {id: 7, name: 'Юмор', icon: 'mdi-home'},
        {id: 8, name: 'Еда', icon: 'mdi-home'},
        {id: 9, name: 'Хобби и Досуг', icon: 'mdi-home'},
        {id: 10, name: 'Музыка', icon: 'mdi-home'},
        {id: 11, name: 'Кино', icon: 'mdi-home'},
        {id: 12, name: 'Путешествия', icon: 'mdi-home'},
        {id: 13, name: 'Покупки', icon: 'mdi-home'},
        {id: 14, name: 'Домоводство', icon: 'mdi-home'},
        {id: 15, name: 'Животные', icon: 'mdi-home'},
        {id: 16, name: 'Дети', icon: 'mdi-home'},
        {id: 17, name: 'Религия и Эзотерика', icon: 'mdi-home'},
        {id: 18, name: 'Личное', icon: 'mdi-home'},
        {id: 19, name: 'Посмотреть позже', icon: 'mdi-home'},
      ],
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>