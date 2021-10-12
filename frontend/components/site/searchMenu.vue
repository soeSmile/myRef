<template>
  <nav class="sm-menu-search">
    <div class="search">
      <b-field>
        <b-input placeholder="Глобальный поиск"
                 v-model="search"
                 type="search"
                 icon="magnify">
        </b-input>
      </b-field>
    </div>

    <div class="sm-line sm-mt-4 sm-mb-4"></div>

    <b-field custom-class="sm-color-dark sm-fnt 600"
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
                type="is-primary">
        Поиск
      </b-button>
      <b-button type="is-link"
                @clear="clear">
        Сброс
      </b-button>
    </div>

  </nav>
</template>

<script>
export default {
  name: "searchMenu",

  props: {},

  data() {
    return {
      loadingTag    : false,
      tags          : [],
      search        : null,
      selectCategory: null,
      selectTag     : null,
      selected      : null,
      request       : {
        ref  : true,
        note : false,
        date : false,
        top  : false,
        cats : [],
        tags : [],
        owner: false,
        flag : 'public'
      },
    };
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
  },

  methods: {
    clear() {

    },

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

        this.$axios.get('/api/tags', {params: {tag: tag}})
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
  },
};
</script>