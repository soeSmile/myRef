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

    <b-field label="Выбрать тег">
      <b-autocomplete placeholder="Выбрать тег"
                      :loading="loading"
                      v-model="selectTag"
                      ref="autocomplete"
                      :data="tags"
                      @typing="getTags"
                      @select="option => selected = option">
      </b-autocomplete>
    </b-field>

  </nav>
</template>

<script>
export default {
  name: "searchMenu",

  props: {},

  data() {
    return {
      loading       : false,
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
      this.$axios.get('/api/tags', {params: {tag: tag}})
          .then(response => {
            this.tags = response.data.data;
          })
          .catch(error => {
          })
    },
  },
};
</script>