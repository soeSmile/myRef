<template>
  <div>
    <nav class="sm-nav sm-bg-color-4 sm-color-color-3">
      <div class="sm-nav-start">
        <div class="sm-nav-item sm-p-4 sm-link-hover sm-hover-color-4 sm-hover-bg-color-3"
             @click="getAll()">
          <i class="mdi mdi-reload sm-mr-1"></i>
          <span>Reload</span>
        </div>
        <n-link to="/admin/user/new"
                class="sm-nav-item sm-p-4 sm-link sm-hover-color-4 sm-hover-bg-color-3">
          <i class="mdi mdi-plus sm-mr-1"></i>
          <span>Add User</span>
        </n-link>
      </div>
    </nav>
  </div>
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