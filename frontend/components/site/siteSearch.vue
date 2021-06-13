<template>
  <v-card class="mt-4">
    <v-card-title>
      Поиск
    </v-card-title>
    <v-card-text>
      <v-switch v-model="request.ref" dense hide-details label="Поиск по закадкам"/>
      <v-switch v-model="request.note" dense hide-details label="Поиск по заметкам"/>

      <v-select class="mt-4"
                :items="filterCategory"
                label="Категории"
                item-text="name"
                item-value="id"
                return-object
                v-model="selectCategory"
                @input="insertCategory"/>
      <v-chip class="ma-2"
              close
              @click:close="removeFromCats(key)"
              v-for="(val,key) in request.cats" :key="key + 'cat'">
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
              @click:close="clearItem(key,'selectTags')"
              v-for="(val,key) in request.tags" :key="key + 'tag'">
        {{ val.name }}
      </v-chip>

      <v-switch v-model="request.date" dense hide-details label="По дате"/>
      <v-switch v-model="request.top" dense hide-details label="Самые посещаемые"/>
    </v-card-text>

    <v-card-actions>
      <v-btn text color="blue darken-4"
             @click="search">
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
      tags          : [],
      selectCategory: null,
      selectTag     : null,
      request       : {
        ref : true,
        note: true,
        date: false,
        top : false,
        cats: [],
        tags: [],
      }
    }
  },

  computed: {
    filterCategory() {
      return this.categories.filter(x => !this.request.cats.includes(x))
    },
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  watch: {},

  methods: {
    /**
     * @param item
     */
    insertCategory(item) {
      this.request.cats.push(item)
    },

    /**
     * @param item
     */
    insertTag(item) {
      if (item !== null && !this.request.tags.includes(item)) {
        this.request.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeFromCats(key) {
      this.request.cats.splice(key, 1)
    },

    /**
     * search
     */
    search() {
      this.$store.dispatch('links/setUrl', {params: this.makeRequest()})
    },

    /**
     * clear request
     */
    clear() {
      this.request = {
        ref : true,
        note: true,
        date: false,
        top : false,
        cats: [],
        tags: []
      }
      this.selectCategory = null
      this.selectTag = null
      this.$store.dispatch('links/setUrl', {params: {}, clear: true})
    },

    /**
     * @return {{}}
     */
    makeRequest() {
      let result = {}

      for (let i in this.request) {
        if (this.request[i] instanceof Array) {
          if (this.request[i].length > 0) {
            result[i] = JSON.stringify(this.request[i].map((item) => item.id))
          }
        } else if (this.request[i]) {
          result[i] = this.request[i]
        }
      }

      result.count = this.$const.COUNT_PAGE

      return result
    }
  }
}
</script>