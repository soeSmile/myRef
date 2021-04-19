<template>
  <v-container>
    <v-card class="mt-4">
      <v-card-text>
        <v-select :items="filterCategory"
                  label="Категории"
                  item-text="name"
                  item-value="id"
                  return-object
                  v-model="selectCategory"
                  @input="insertCategory"/>
        <v-chip class="ma-2"
                close
                @click:close="clearItem(key)"
                v-for="(val,key) in selectCategories" :key="key + 'cat'">
          {{ val.name }}
        </v-chip>

        <v-autocomplete class="mt-4"
                        :items="tags"
                        label="Теги"
                        item-text="name"
                        item-value="id"
                        return-object
                        clearable
                        v-model="selectTag"
                        @input="insertTag"/>
        <v-chip class="ma-2"
                close
                @click:close="clearItem(key,'selectTag')"
                v-for="(val,key) in selectTags" :key="key + 'tag'">
          {{ val.name }}
        </v-chip>
      </v-card-text>

      <v-card-actions>
        <v-btn text color="blue darken-4">
          Поиск
          <v-icon right>mdi-cloud-search-outline</v-icon>
        </v-btn>
        <v-btn text color="blue darken-4"
               @click="clear">
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
      loading         : false,
      categories      : [
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
      selectCategories: [],
      tags            : [
        {id: 1, name: 'php'},
        {id: 2, name: 'css'},
        {id: 3, name: 'go'},
      ],
      selectTags      : [],
      selectCategory  : null,
      selectTag       : null
    }
  },

  computed: {
    filterCategory() {
      return this.categories.filter(x => !this.selectCategories.includes(x))
    }
  },

  watch: {},

  methods: {
    /**
     * @param item
     */
    insertCategory(item) {
      this.selectCategories.push(item)
    },

    /**
     * @param item
     */
    insertTag(item) {
      if (item !== null && !this.selectTags.includes(item)) {
        this.selectTags.push(item)
      }
    },

    /**
     * @param key
     * @param item
     */
    clearItem(key, item = 'selectCategory') {
      this[item].splice(key, 1)
    },

    clear() {
      this.selectCategory = null
      this.selectTag = null
      this.selectCategories = []
      this.selectTags = []
    }
  }
}
</script>