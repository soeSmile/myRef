<template>
  <div class="sm-flex middle wrap sm-p-4 sm-bg-white">
    <div class="sm-link sm-color-grey sm-hover-primary sm-mr-4"
         @click="clear">
      <i class="mdi mdi-close-thick"></i>
    </div>

    <div class="sm-w-30 sm-mr-4">
      <b-select placeholder="Выбор категории"
                expanded
                v-model="selectCategory"
                @input="insertCategory"
                @typing="insertCategory">
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

    insertTag(item) {
      console.log(item);
    }
  }
}
</script>