<template>
  <v-card>

    <v-card-title>
      <v-btn icon class="mx-2"
             @click="getAll()">
        <v-icon>mdi-cached</v-icon>
      </v-btn>
      <v-btn text class="mx-2"
             to="./category/new">
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
        :options.sync="options"
        :search="search">
      <template v-slot:item.actions="{ item }">
        <v-btn icon class="mx-2"
               :to="'/admin/category/' + item.id">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
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
      options   : {},
      query     : {
        count: 20,
        page : 1
      },
      search    : '',
      headers   : [
        {text: '', value: 'actions', sortable: false, width: 50},
        {text: 'id', value: 'id'},
        {text: 'RU', value: 'ru'},
        {text: 'EN', value: 'en'},
        {text: 'Active', value: 'active'},
        {text: 'Updated', value: 'updatedAt'},
      ],
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