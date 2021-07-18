<template>
  <div class="sm-paginate">
    <ul>
      <li class="item"
          v-if="pagination.current_page >= 3"
          @click="changePage(1)">
        1
      </li>
      <li class="item"
          v-for="(val,key) in pages" @click="changePage(val)"
          :class="val === pagination.current_page ? 'active' : ''">
        {{ val }}
      </li>
      <li class="more"
          v-if="pagination.current_page < pagination.last_page - 2 && pagination.current_page <= pagination.last_page - 3">
        .....
      </li>
      <li class="item"
          v-if="pagination.current_page <= pagination.last_page - 2"
          @click="changePage(pagination.last_page)">
        {{ pagination.last_page }}
      </li>

    </ul>
  </div>
</template>

<script>
export default {

  name: "uiPagination",

  created() {
  },

  mounted() {
  },

  props: {
    pagination: {
      type    : Object,
      required: true
    },
    links     : {
      type: Object,
    },
    store     : {
      type   : String,
      default: ''
    },
    event     : {
      type   : Function,
      default: () => {
      }
    },
    countShow : {
      type   : Number,
      default: 20
    },
  },

  data() {
    return {
      count: this.countShow
    }
  },

  computed: {
    /**
     * count pagination
     */
    pages() {
      if (!this.pagination.to) {
        return [];
      }

      let pagesArray = [];
      const left = Math.max(1, this.pagination.current_page - 1);
      const right = Math.min(this.pagination.current_page + 1, this.pagination.last_page);

      for (let i = left; i <= right; i++) {
        pagesArray.push(i);
      }

      return pagesArray;
    },
  },

  methods: {
    /**
     * paginate
     * @param page
     */
    changePage(page) {
      if (this.store) {
        this.$store.dispatch(this.store, {params: {count: this.count, page: page}});
      } else {
        this.event({count: this.count, page: page})
      }
    }
  }
}
</script>