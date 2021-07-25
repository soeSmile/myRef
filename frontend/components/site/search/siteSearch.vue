<template>
  <aside class="sm-flex col sm-mt-4">
    <div class="sm-flex col">
      <div class="sm-mt-4">
        <p class="sm-mb-2 sm-color-dark">Поиск по закадкам</p>
        <el-switch v-model="request.ref">
        </el-switch>
      </div>
      <div class="sm-mt-4">
        <p class="sm-mb-2 sm-color-dark">Поиск по заметкам</p>
        <el-switch v-model="request.note">
        </el-switch>
      </div>
      <div class="sm-mt-4">
        <p class="sm-mb-2 sm-color-dark">Выбор категории</p>
        <el-select class="sm-w-100"
                   v-model="selectCategory"
                   @change="insertCategory"
                   filterable
                   placeholder="Категория">
          <el-option
              v-for="item in filterCategory"
              :key="item.id"
              :label="item.name"
              :value="item">
          </el-option>
        </el-select>
      </div>
      <div class="sm-mt-4" v-if="request.cats.length > 0">
        <el-tag class="sm-m-1"
                v-for="(val,key) in request.cats"
                :key="key"
                closable
                @close="removeFromCats(key)">
          {{ val.name }}
        </el-tag>
      </div>
      <div class="sm-mt-4">
        <p class="sm-mb-2 sm-color-dark">Выбор тега</p>
        <el-select class="sm-w-100"
                   v-model="selectTag"
                   filterable
                   remote
                   reserve-keyword
                   placeholder="Тэг"
                   :remote-method="getTags"
                   @change="insertTag"
                   :loading="loading">
          <el-option v-for="(item,k) in tags"
                     :key="item.name"
                     :label="item.name"
                     :value="item">
          </el-option>
        </el-select>
      </div>
      <div class="sm-mt-4" v-if="request.tags.length > 0">
        <el-tag class="sm-m-1"
                v-for="(val,key) in request.tags"
                :key="key"
                closable
                @close="removeFromTags(key)">
          {{ val.name }}
        </el-tag>
      </div>
    </div>
    <div class="sm-mt-8">
      <el-button type="primary"
                 @click="search">
        Поиск
      </el-button>
      <el-button @click="clear">
        Очистить
      </el-button>
    </div>
  </aside>
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
        note: false,
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

  watch: {
    searchTag: function (newVal) {
      if (newVal && newVal.length > 2) {
        this.getTags()
      }
    }
  },

  methods: {
    /**
     * @param item
     */
    insertCategory(item) {
      this.selectCategory = null
      this.request.cats.push(item)
    },

    /**
     * @param item
     */
    insertTag(item) {
      this.selectTag = null
      let id = this.request.tags.find(x => x.id === item.id)

      if (!id) {
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
     * @param key
     */
    removeFromTags(key) {
      this.request.tags.splice(key, 1)
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
        note: false,
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
    },

    /**
     * @param tag
     */
    getTags(tag) {
      this.$axios.get('/api/tags', {params: {tag: tag}})
          .then(response => {
            this.tags = response.data.data;
          })
          .catch(error => {
          })
    }
  }
}
</script>