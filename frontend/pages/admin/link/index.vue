<template>
  <section>
    <nav class="sm-nav sm-bg-white sm-color-grey sm-p-2">
      <div class="sm-nav-start">
        <div class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary"
             @click="getAll(true)">
          <i class="mdi mdi-reload sm-mr-1"></i>
          <span>Обновить</span>
        </div>
        <n-link to="/admin/category/new"
                class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-plus sm-mr-1"></i>
          <span>Добавить</span>
        </n-link>
      </div>
      <div class="sm-nav-end">
      </div>
    </nav>

    <div class="sm-mt-8">
    </div>
  </section>
</template>

<script>
export default {
  name: "link_index",

  layout: 'admin',

  head() {
    return {
      title: 'Link'
    }
  },

  created() {
    this.getAll(true)
  },

  data() {
    return {
      loading   : false,
      pagination: {
        itemsPerPage: 20,
        total       : 0
      },
      query     : {
        count: 20,
        page : 1
      },
      links     : [],
    }
  },

  methods: {
    /**
     * @param clear
     */
    getAll(clear = false) {
      this.loading = true

      if (clear) {
        this.query.tag = null
      }

      this.$axios.get('/api/links', {params: this.query})
          .then(response => {
            this.links = response.data.data;

            if (this.query.count) {
              this.pagination.page = parseInt(response.data.meta.current_page);
              this.pagination.itemsPerPage = parseInt(response.data.meta.per_page);
              this.pagination.total = parseInt(response.data.meta.total);
            }
          })
          .catch(error => {
            console.log(error)
          })
          .finally(() => {
            this.loading = false
          })
    }
  }
}
</script>