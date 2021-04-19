<template>
  <v-container>
    <v-card class="mt-4">
      <v-card-text>
        <v-select :items="filterCategory"
                  label="Категории"
                  item-text="name"
                  item-value="id"
                  return-object
                  @input="insertCategory"/>

        <v-chip class="ma-2"
                close
                @click:close="clearCategory(key)"
                v-for="(val,key) in selectCategory" :key="key">
          {{ val.name }}
        </v-chip>

        <v-autocomplete :items="tags"
                        label="Теги"
                        clearable/>
      </v-card-text>

      <v-card-actions>
        <v-btn text color="blue darken-4">
          Поиск
          <v-icon right>mdi-cloud-search-outline</v-icon>
        </v-btn>
        <v-btn text color="blue darken-4">
          Очистить
          <v-icon right>mdi-close</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "siteSearch",

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      loading       : false,
      categories    : [
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
      selectCategory: [],

      tags: ['Alabama', 'Alaska', 'American Samoa', 'Arizona', 'Arkansas', 'California']
    }
  },

  computed: {
    filterCategory() {
      return this.categories.filter(x => !this.selectCategory.includes(x))
    }
  },

  watch: {},

  methods: {
    /**
     * @param item
     */
    insertCategory(item) {
      this.selectCategory.push(item)
    },

    clearCategory(key) {
      this.selectCategory.splice(key, 1)
    }
  }
}
</script>