<template>
  <div class="sm-flex col sm-bg-white sm-p-4">
    <div class="sm-flex middle wrap">
      <div class="sm-w-30 sm-mr-4">
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
      </div>

      <div class="sm-w-30 sm-mr-4">
        <b-taginput placeholder="Выбор тега"
                    v-model="selectTag"
                    :before-adding="insertTag">
        </b-taginput>
      </div>

      <b-button class="sm-mr-2"
                type="is-success">
        Поиск
      </b-button>
      <b-button type="is-link"
                @clear="clear">
        Сброс
      </b-button>
    </div>

    <div class="sm-flex middle wrap sm-mt-2">
      <div class="sm-w-30">
        <b-tag class="sm-m-1"
               v-for="(val,key) in request.cats"
               :key="val.name"
               type="is-success"
               closable
               @close="removeCategory(key)">
          {{ val.name }}
        </b-tag>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "siteSearchHead",

  data() {
    return {
      selectCategory: null,
      selectTag     : null,
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
    }
  },

  computed: {
    filterCategory() {
      return this.categories.filter(x => !this.request.cats.includes(x))
    },
    categories() {
      return this.$store.getters['category/categories'];
    },
  },

  methods: {
    clear() {
      this.request = {
        cats: [],
        tags: [],
      };
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

    insertTag(item) {
      console.log(item);
    }
  }
}
</script>