<template>
  <section>
    <nav class="sm-nav sm-bg-color-10 sm-color-color-9">
      <div class="sm-nav-start">
        <div class="sm-nav-item sm-p-4 sm-link-hover sm-hover-color-10 sm-hover-bg-color-9"
             @click="getAll(true)">
          <i class="mdi mdi-reload sm-mr-1"></i>
          <span>Обновить</span>
        </div>
        <n-link to="/admin/tag/new"
                class="sm-nav-item sm-p-4 sm-link sm-hover-color-10 sm-hover-bg-color-9">
          <i class="mdi mdi-plus sm-mr-1"></i>
          <span>Добавить</span>
        </n-link>
      </div>
      <div class="sm-nav-end">
        <div class="sm-nav-item">
          <el-input placeholder="Поиск"
                    v-model="query.tag">
            <el-button @click="getAll()"
                       slot="append"
                       icon="el-icon-search"></el-button>
          </el-input>
        </div>
      </div>
    </nav>

    <div class="sm-mt-8">
      <el-table :data="tags"
                v-loading="loading"
                style="width: 100%">
        <el-table-column width="40">
          <template slot-scope="scope">
            <n-link :to="'/admin/tag/' + scope.row.id"
                    class="sm-hover-color-7">
              <i class="mdi mdi-pencil"></i>
            </n-link>
          </template>
        </el-table-column>
        <el-table-column prop="id"
                         width="40"
                         label="id"/>
        <el-table-column prop="name"
                         label="Name"/>
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
  name: "tag_index",

  layout: 'admin',

  head() {
    return {
      title: 'Tag'
    }
  },

  created() {
    this.getAll(true)
  },

  props: {},

  data() {
    return {
      loading   : false,
      pagination: {
        itemsPerPage: 20,
        total       : 0
      },
      query     : {
        tag  : null,
        count: 20,
        page : 1
      },
      tags      : [],
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

      this.$axios.get('/api/tags', {params: this.query})
          .then(response => {
            this.tags = response.data.data;

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