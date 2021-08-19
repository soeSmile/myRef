<template>
  <aside class="sm-flex col sm-mt-4">
    <div class="sm-flex col">
      <section v-if="isClient">
        <div class="sm-mt-4">
          <p class="sm-mb-2 sm-color-dark">
            Быстрый доступ
          </p>
          <div @click="$store.dispatch('links/setUrl', {params: JSON.parse(val.link)})"
               class="sm-flex middle sm-p-2 sm-hover-bg-light sm-link"
               v-for="(val,key) in user.links" :key="val.id">
            <i class="mdi mdi-close sm-mr-1 sm-color-color-7 sm-link"
               @click.stop="deleteSearchUrl(key)"></i>
            <i class="mdi mdi-pencil sm-mr-1 sm-color-color-1 sm-link"
               @click.stop="editSearchUrl(key)"></i>
            <div class="sm-color-dark">
              {{ val.name }}
            </div>
          </div>
        </div>
        <el-divider/>
        <div class="sm-mt-4">
          <p class="sm-mb-2 sm-color-dark">Статус</p>
          <el-select class="sm-w-100"
                     v-model="request.flag"
                     placeholder="Статус">
            <el-option
                v-for="item in flags"
                :key="item.id"
                :label="item.name"
                :value="item.id">
            </el-option>
          </el-select>
        </div>
        <div class="sm-mt-4">
          <p class="sm-mb-2 sm-color-dark">Только свои</p>
          <el-switch v-model="request.owner"/>
        </div>
        <div class="sm-mt-4">
          <el-button type="success" size="small"
                     @click="addSearchUrl">
            Добавить в Быстрый доступ
          </el-button>
        </div>
        <el-divider/>
      </section>

      <div class="sm-mt-4">
        <p class="sm-mb-2 sm-color-dark">Поиск по закадкам</p>
        <el-switch v-model="request.ref"/>
      </div>
      <div class="sm-mt-4">
        <p class="sm-mb-2 sm-color-dark">Поиск по заметкам</p>
        <el-switch v-model="request.note"/>
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

    <add-search-link v-if="showAddSearchUrl"
                     :searchUrl="searchUrl"
                     @close="closeSearchUrl"
                     @store="storeSearchUrl"/>
  </aside>
</template>

<script>

import addSearchLink from "./addSearchLink";

export default {
  name: "siteSearch",

  components: {
    addSearchLink
  },

  props: {},

  data() {
    return {
      showAddSearchUrl: false,
      loading         : false,
      tags            : [],
      selectCategory  : null,
      selectTag       : null,
      flags           : [
        {id: 'public', name: 'Публичные'},
        {id: 'privat', name: 'Приватные'},
      ],
      request         : {
        ref  : true,
        note : false,
        date : false,
        top  : false,
        cats : [],
        tags : [],
        owner: false,
        flag : 'public'
      },
      searchUrl       : {
        name: 'Ссылка на поиск',
        link: null
      }
    }
  },

  computed: {
    filterCategory() {
      return this.categories.filter(x => !this.request.cats.includes(x))
    },
    categories() {
      return this.$store.getters['category/categories'];
    },
    user() {
      return this.$store.getters['auth/user'];
    }
  },

  watch: {
    searchTag     : function (newVal) {
      if (newVal && newVal.length > 2) {
        this.getTags()
      }
    },
    'request.flag': function (val) {
      if (val === 'privat') {
        this.request.owner = true;
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
      this.tags = []
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
    },

    /**
     * show add user search link
     */
    addSearchUrl() {
      this.showAddSearchUrl = true;
      this.searchUrl.link = JSON.stringify(this.$route.query);
    },

    /**
     * close pop add user show link
     */
    closeSearchUrl() {
      this.showAddSearchUrl = false;
      this.searchUrl.name = 'Ссылка на поиск'
      this.searchUrl.link = null
    },

    /**
     * store user search link
     */
    storeSearchUrl() {
      let method = 'post',
          link   = 'api/user-links';

      if (this.searchUrl.id) {
        method = 'put';
        link = 'api/user-links/' + this.searchUrl.id;
      }

      this.$axios[method](link, this.searchUrl)
          .then(response => {
            this.$message({
              message: 'Saved !',
              type   : 'success'
            })

            if (method === 'post') {
              this.$store.commit('auth/SET_USER_LINKS', response.data.data)
            } else {
              this.$store.commit('auth/UPDATE_USER_LINKS', {...this.searchUrl})
            }
            this.closeSearchUrl()
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$message({
              type                    : 'error',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            })
          });
    },

    /**
     * edit user search link
     * @param key
     */
    editSearchUrl(key) {
      this.showAddSearchUrl = true;
      this.searchUrl = Object.assign({}, this.user.links[key])
    },

    /**
     * delete user search link
     * @param key
     */
    deleteSearchUrl(key) {
      this.$confirm('Удалить ?', 'Внимание', {
        confirmButtonText: 'Да',
        cancelButtonText : 'Нет',
        type             : 'warning'
      }).then(() => {
        this.$axios.delete('api/user-links/' + this.searchUrl.id)
            .then(response => {
              this.$message({
                message: 'Success !',
                type   : 'success'
              })
              this.$store.commit('auth/REMOVE_USER_LINK', key)
            })
            .catch(e => {
              this.errors = e.response.data.errors;

              this.$message({
                type                    : 'error',
                dangerouslyUseHTMLString: true,
                message                 : this.$messageToStr(this.errors),
              })
            });
      })
    }
  }
}
</script>