<template>
  <section>
    <nav class="sm-nav sm-bg-white sm-color-dark">
      <div class="sm-nav-start">
        <div class="sm-nav-item sm-p-4 sm-link sm-hover-white sm-hover-bg-primary"
             @click="getAll(true)">
          <i class="mdi mdi-reload sm-mr-1"></i>
          <span>Обновить</span>
        </div>
        <n-link to="/admin/category/new"
                class="sm-nav-item sm-p-4 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-plus sm-mr-1"></i>
          <span>Добавить</span>
        </n-link>
      </div>
      <div class="sm-nav-end">
        <div class="sm-nav-item">
          <b-field>
            <b-input placeholder="Поиск"
                     type="search"
                     v-model="query.name"/>
            <p class="control">
              <b-button @click="getAll()"
                        class="button is-primary">
                Поиск
              </b-button>
            </p>
          </b-field>
        </div>
      </div>
    </nav>

    <div class="sm-p-4">
      <b-table
          :data="categories"
          :loading="loading"
          paginated
          backend-pagination
          :total="pagination.total"
          :per-page="pagination.itemsPerPage"
          @page-change="onPageChange"
      >
        <b-table-column v-slot="props">
          <n-link :to="'/admin/category/' + props.row.id"
                  class="sm-hover-primary">
            <i class="mdi mdi-pencil"></i>
          </n-link>
        </b-table-column>
        <b-table-column field="id"
                        label="id"
                        v-slot="props">
          {{ props.row.id }}
        </b-table-column>
        <b-table-column field="icon"
                        label="Icon"
                        v-slot="props">
          {{ props.row.icon }}
        </b-table-column>
        <b-table-column field="ru"
                        label="RU"
                        v-slot="props">
          {{ props.row.ru }}
        </b-table-column>
        <b-table-column field="en"
                        label="EN"
                        v-slot="props">
          {{ props.row.en }}
        </b-table-column>
        <b-table-column field="active"
                        label="Active"
                        v-slot="props">
          <i v-if="props.row.active"
             class="mdi mdi-check sm-color-green"></i>
          <i v-else
             class="mdi mdi-close sm-color-red"></i>
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
        name : null,
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

      if (clear) {
        this.query.name = null
      }

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