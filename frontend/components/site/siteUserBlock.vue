<template>
  <v-card class="mt-4">
    <v-card-title>
      Бок пользователя
    </v-card-title>

    <v-list-group :value="false" no-action sub-group>
      <template v-slot:activator>
        <v-list-item-title>Категории</v-list-item-title>
      </template>

      <v-list-item link
                   v-for="(val,key) in categories" :key="key">
        <v-list-item-title v-text="val.name"></v-list-item-title>

        <v-list-item-icon>
          <v-icon v-text="id"></v-icon>
        </v-list-item-icon>
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
        {id: 1, name: 'Новости'},
        {id: 2, name: 'Наука'},
        {id: 3, name: 'Техника'},
        {id: 4, name: 'Бизнес и Работа'},
        {id: 5, name: 'Образование'},
        {id: 6, name: 'Медицина'},
        {id: 7, name: 'Юмор'},
        {id: 8, name: 'Еда'},
        {id: 9, name: 'Хобби и Досуг'},
        {id: 10, name: 'Музыка'},
        {id: 11, name: 'Кино'},
        {id: 12, name: 'Путешествия'},
        {id: 13, name: 'Покупки'},
        {id: 14, name: 'Домоводство'},
        {id: 15, name: 'Животные'},
        {id: 16, name: 'Дети'},
        {id: 17, name: 'Религия и Эзотерика'},
        {id: 18, name: 'Личное'},
        {id: 19, name: 'Посмотреть позже'}
      ],
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>