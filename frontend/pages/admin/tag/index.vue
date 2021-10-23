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

    <div class="sm-p-4">
      <b-table
          :data="tags"
          :loading="loading"
          paginated
          backend-pagination
          :total="pagination.total"
          :per-page="pagination.itemsPerPage"
          @page-change="onPageChange"
      >
        <b-table-column v-slot="props">
          <n-link :to="'/admin/tag/' + props.row.id"
                  class="sm-hover-primary">
            <i class="mdi mdi-pencil"></i>
          </n-link>
        </b-table-column>
        <b-table-column field="id"
                        label="ID"
                        v-slot="props">
          {{ props.row.id }}
        </b-table-column>
        <b-table-column field="id"
                        label="Name"
                        v-slot="props">
          {{ props.row.name }}
        </b-table-column>
        <b-table-column field="active"
                        label="Active"
                        v-slot="props">
          <i v-if="props.row.active"
             class="mdi mdi-check sm-color-success"></i>
          <i v-else
             class="mdi mdi-close sm-color-alert"></i>
        </b-table-column>
        <b-table-column field="updatedAt"
                        label="Updated"
                        v-slot="props">
          {{ props.row.updatedAt }}
        </b-table-column>
      </b-table>
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
    },

    /**
     * @param page
     */
    onPageChange(page) {
      this.query.page = page;
      this.getAll();
    }
  }
}
</script>