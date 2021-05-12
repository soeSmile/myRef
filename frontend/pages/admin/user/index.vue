<template>
  <v-card>

    <v-card-title>
      <v-btn icon class="mx-2"
             @click="getAll()">
        <v-icon>mdi-cached</v-icon>
      </v-btn>
      <v-btn text class="mx-2"
             to="/admin/user/new">
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
        :items="users"
        :options.sync="pagination"
        :server-items-length="pagination.total"
        :footer-props="{'items-per-page-options': [20, 40, 60]}"
        :search="search">
      <template v-slot:item.actions="{ item }">
        <v-btn icon class="mx-2"
               :to="'/admin/user/' + item.id">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </template>
      <template v-slot:item.confirm="{ item }">
        <v-icon :color="item.confirm ? 'teal' : 'red'">
          {{ item.confirm ? 'mdi-checkbox-marked-circle-outline' : 'mdi-close-circle-outline' }}
        </v-icon>
      </template>
    </v-data-table>

  </v-card>
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
      search    : '',
      headers   : [
        {text: '', value: 'actions', sortable: false, width: 50},
        {text: 'id', value: 'id'},
        {text: 'Name', value: 'name'},
        {text: 'Email', value: 'email'},
        {text: 'Confirm', value: 'confirm'},
        {text: 'Time Zone', value: 'timeZone'},
        {text: 'Role', value: 'role'},
        {text: 'Updated', value: 'updatedAt'},
      ],
      users     : []
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