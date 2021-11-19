<template>
  <nav class="sm-menu-search">
    <div class="search">
      <b-field>
        <b-input placeholder="Глобальный поиск"
                 v-model="searchText"
                 type="search"
                 icon="magnify"
                 icon-right="close-circle"
                 icon-right-clickable
                 @icon-right-click="searchText = ''">
        </b-input>
      </b-field>
    </div>

    <div class="sm-line sm-mt-4 sm-mb-4"></div>

    <search-user-menu
        v-if="isClient"
        :request="request"/>

    <b-field>
      <b-switch
          v-model="selectTypeRef">
        Поиск по закладкам
      </b-switch>
    </b-field>

    <b-field>
      <b-switch
          v-model="selectTypeNote">
        Поиск по заметкам
      </b-switch>
    </b-field>

    <b-field custom-class="sm-mt-2 sm-color-dark sm-fnt w600"
             label="Выбор категории">
      <b-select placeholder="Выбор категории"
                expanded
                v-model="selectCategory"
                @input="insertCategory">
        <option v-for="val in filterCategory"
                :value="val"
                :key="val.id">
          {{ val.name }}
        </option>
      </b-select>
    </b-field>

    <div class="sm-flex wrap sm-mt-2">
      <b-tag class="sm-m-1"
             v-for="(val,key) in request.cats"
             :key="val.name"
             type="is-success"
             closable
             @close="removeCategory(key)">
        {{ val.name }}
      </b-tag>
    </div>

    <b-field class="sm-mt-4"
             custom-class="sm-color-dark sm-fnt w600"
             label="Выбрать тег">
      <b-autocomplete placeholder="Выбрать тег"
                      :loading="loadingTag"
                      v-model="selectTag"
                      ref="autocomplete"
                      :data="tags"
                      @typing="getTags"
                      @select="insertTag">
        <template #empty>Нет данных по запросу: {{ selectTag }}</template>
        <template slot-scope="props">
          {{ props.option.name }}
        </template>
      </b-autocomplete>
    </b-field>

    <div class="sm-flex wrap sm-mt-2">
      <b-tag class="sm-m-1"
             v-for="(val,key) in request.tags"
             :key="val.name"
             type="is-warning"
             closable
             @close="removeTag(key)">
        {{ val.name }}
      </b-tag>
    </div>

    <div class="sm-flex wrap sm-mt-6">
      <b-button class="sm-mr-2"
                type="is-primary"
                @click="searchRequest">
        Поиск
      </b-button>
      <b-button type="is-link"
                @click="resetRequest">
        Сброс
      </b-button>
    </div>

  </nav>
</template>

<script>
import SearchUserMenu from "./searchMenu/searchUserMenu";

export default {
  name: "searchMenu",

  components: {
    SearchUserMenu
  },

  props: {},

  data() {
    return {
      loadingTag    : false,
      tags          : [],
      searchText    : '',
      selectCategory: null,
      selectTag     : null,
      selectTypeRef : true,
      selectTypeNote: true,
      request       : {
        type : 3,
        flag : 1,
        cats : [],
        tags : [],
        owner: false,
      },
    };
  },

  watch: {
    request: {
      handler: function (val) {
        this.searchRequest();
      },
      deep   : true
    },
    selectTag(val) {
      return val.toLowerCase();
    }
  },

  computed: {
    /**
     * @return {array}
     */
    filterCategory() {
      return this.categories.filter(x => !this.request.cats.includes(x))
    },

    /**
     * @return {array}
     */
    categories() {
      return this.$store.getters['category/categories'];
    },

    /**
     * isClient
     * @return {boolean}
     */
    isClient() {
      return this.$store.getters['auth/isClient'];
    }
  },

  created() {
    this.restoreDataFromQuery();
  },

  methods: {
    /**
     * @param item
     */
    insertCategory(item) {
      if (item !== undefined) {
        this.request.cats.push(item);
      }
    },

    /**
     * @param key
     */
    removeCategory(key) {
      this.request.cats.splice(key, 1)
    },

    /**
     * @param tag
     */
    getTags(tag) {
      if (tag.length >= 3) {
        this.loadingTag = true;

        this.$axios.get('/api/tags', {params: {tag: tag.toLowerCase()}})
            .then(res => {
              this.tags = res.data.data;
            })
            .catch(err => {
            })
            .finally(() => {
              this.loadingTag = false;
            })
      }
    },

    /**
     * @param item
     */
    insertTag(item) {
      this.tags = []
      let id = this.request.tags.find(x => x.id === item.id)

      if (!id) {
        this.request.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeTag(key) {
      this.request.tags.splice(key, 1)
    },

    /**
     * @return {{}}
     */
    makeRequest() {
      let result = {}

      if (this.searchText.length >= 3) {
        result.search = this.searchText;
      } else {
        for (let i in this.request) {
          if (this.request[i] instanceof Array) {
            if (this.request[i].length > 0) {
              result[i] = JSON.stringify(this.request[i].map((item) => item.id))
            }
          } else if (this.request[i]) {
            result[i] = this.request[i]
          }
        }
      }

      if (!this.isClient) {
        delete result.flag;
      }

      if (this.selectTypeRef && this.selectTypeNote) {
        result.type = 3;
      }

      return result
    },

    /**
     * search
     */
    searchRequest() {
      this.$store.dispatch('links/setUrl', {params: this.makeRequest()})
    },

    /**
     * reset
     */
    resetRequest() {
      this.request = {
        type : 3,
        flag : 1,
        cats : [],
        tags : [],
        owner: false
      };
      this.searchText = '';
      this.selectCategory = null;
      this.selectTag = null;
      this.selectTypeRef = true;
      this.selectTypeNote = true;
      this.$store.dispatch('links/setUrl', {params: {}, clear: true})
    },

    /**
     * restore data
     */
    restoreDataFromQuery() {
      let query = this.$route.query;

      for (let i in query) {
        switch (i) {
          case 'type' : {
            this.request.type = parseInt(query[i] || 1, 10)
            break;
          }
          case 'flag' : {
            this.request.flag = parseInt(query[i] || 1, 10)
            break;
          }
          case 'cats' : {
            this.request.cats = this.categories.filter(x => JSON.parse(query[i] || []).includes(x.id))
            break;
          }
          case 'tags' : {
            this.setTags(JSON.parse(query[i] || []));
            break;
          }
        }
      }
    },

    /**
     * set tag
     * @param ids
     */
    setTags(ids) {
      this.$axios.get('/api/tags', {params: {ids: JSON.stringify(ids)}})
          .then(res => {
            this.request.tags = res.data.data.filter(x => ids.includes(x.id))
          })
          .catch(err => {
          })
    },
  },
};
</script>