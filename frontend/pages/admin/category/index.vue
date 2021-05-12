<template>
  <v-card>

    <v-card-title>
      <v-btn icon class="mx-2"
             @click="getAll()">
        <v-icon>mdi-cached</v-icon>
      </v-btn>
      <v-btn text class="mx-2"
             to="/admin/category/new">
        <v-icon left>
          mdi-plus
        </v-icon>
        Add
      </v-btn>
      <v-spacer/>
      <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details/>
    </v-card-title>

    <v-data-table
        :loading="loading"
        :headers="headers"
        :items="categories"
        :options.sync="pagination"
        :server-items-length="pagination.total"
        :footer-props="{'items-per-page-options': [20, 40, 60]}"
        :search="search">
      <template v-slot:item.actions="{ item }">
        <v-btn icon class="mx-2"
               :to="'/admin/category/' + item.id">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </template>
      <template v-slot:item.icon="{ item }">
        <v-icon>{{ item.icon }}</v-icon>
      </template>
      <template v-slot:item.active="{ item }">
        <v-icon :color="item.active ? 'teal' : 'red'">
          {{ item.active ? 'mdi-checkbox-marked-circle-outline' : 'mdi-close-circle-outline' }}
        </v-icon>
      </template>
    </v-data-table>

  </v-card>
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
      search    : '',
      headers   : [
        {text: '', value: 'actions', sortable: false, width: 50},
        {text: 'id', value: 'id'},
        {text: 'Icon', value: 'icon'},
        {text: 'RU', value: 'ru'},
        {text: 'EN', value: 'en'},
        {text: 'Active', value: 'active'},
        {text: 'Updated', value: 'updatedAt'},
      ],
      categories: []
    }
  },

  watch: {
    pagination: {
      handler(newVal, oldVal) {
        if (oldVal.page) {
          this.query.page = newVal.page;
          this.query.count = newVal.itemsPerPage;
          this.getAll();
        }
      },
      deep: true,
    },
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