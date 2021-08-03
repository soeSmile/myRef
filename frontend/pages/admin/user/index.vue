<template>
  <section>
    <nav class="sm-nav sm-bg-color-10 sm-color-color-9">
      <div class="sm-nav-start">
        <div class="sm-nav-item sm-p-4 sm-link-hover sm-hover-color-10 sm-hover-bg-color-9"
             @click="getAll()">
          <i class="mdi mdi-reload sm-mr-1"></i>
          <span>Обновить</span>
        </div>
        <n-link to="/admin/user/new"
                class="sm-nav-item sm-p-4 sm-link sm-hover-color-10 sm-hover-bg-color-9">
          <i class="mdi mdi-plus sm-mr-1"></i>
          <span>Добавить</span>
        </n-link>
      </div>
    </nav>

    <div class="sm-mt-8">
      <el-table :data="users"
                v-loading="loading"
                style="width: 100%">
        <el-table-column width="40"/>
        <el-table-column prop="id"
                         label="id"/>
        <el-table-column prop="name"
                         label="Name"/>
        <el-table-column prop="email"
                         label="Email"/>
        <el-table-column prop="confirm"
                         label="Confirm">
          <template slot-scope="scope">
            <i v-if="scope.row.confirm"
               class="mdi mdi-check sm-color-green"></i>
            <i v-else
               class="mdi mdi-close sm-color-red"></i>
          </template>
        </el-table-column>
        <el-table-column prop="timeZone"
                         label="Time Zone"/>
        <el-table-column prop="role"
                         label="Role"/>
        <el-table-column prop="updatedAt"
                         label="Updated"/>
      </el-table>
    </div>
  </section>
</template>

<script>
export default {
  name: "user_index",

  layout: 'admin',

  head() {
    return {
      title: 'User'
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
      users     : []
    }
  },

  methods: {
    /**
     * @param clear
     */
    getAll(clear = false) {
      this.loading = true

      this.$axios.get('/api/users', {params: this.query})
          .then(response => {
            this.users = response.data.data;

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