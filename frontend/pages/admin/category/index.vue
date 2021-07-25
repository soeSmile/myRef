<template>
  <section>
    <nav class="sm-nav sm-bg-color-10 sm-color-color-9">
      <div class="sm-nav-start">
        <div class="sm-nav-item sm-p-4 sm-link-hover sm-hover-color-10 sm-hover-bg-color-9"
             @click="getAll()">
          <i class="mdi mdi-reload sm-mr-1"></i>
          <span>Reload</span>
        </div>
        <n-link to="/admin/user/new"
                class="sm-nav-item sm-p-4 sm-link sm-hover-color-10 sm-hover-bg-color-9">
          <i class="mdi mdi-plus sm-mr-1"></i>
          <span>Add Category</span>
        </n-link>
      </div>
    </nav>

    <div class="sm-mt-8">
      <el-table :data="categories"
                style="width: 100%">
        <el-table-column width="40"/>
        <el-table-column prop="id"
                         width="40"
                         label="id"/>
        <el-table-column prop="icon"
                         label="Icon"/>
        <el-table-column prop="ru"
                         label="RU"/>
        <el-table-column prop="en"
                         label="EN"/>
        <el-table-column prop="active"
                         label="Active">
          <template slot-scope="scope">
            <i v-if="scope.row.active"
               class="mdi mdi-check sm-color-green"></i>
            <i v-else
               class="mdi mdi-close sm-color-red"></i>
          </template>
        </el-table-column>
        <el-table-column prop="updatedAt"
                         label="Updated"/>
      </el-table>
    </div>
  </section>
</template>

<script>
export default {
  name: "category_index",

  layout: 'admin',

  head() {
    return {
      title: 'Category'
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
      categories: []
    }
  },

  methods: {
    /**
     * @param clear
     */
    getAll(clear = false) {
      this.loading = true

      this.$axios.get('/api/categories', {params: this.query})
          .then(response => {
            this.categories = response.data.data;

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