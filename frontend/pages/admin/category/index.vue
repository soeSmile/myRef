<template>
  <v-card>
    <v-card-title>
      <v-btn icon class="mx-2"
             @click="getAll()">
        <v-icon>mdi-cached</v-icon>
      </v-btn>
      <v-btn text class="mx-2" @click="add">
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
        <v-btn icon class="mx-2" @click="edit(item)">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </template>
      <template v-slot:item.active="{ item }">
        <v-icon :color="item.active ? 'teal' : 'red'">
          {{ item.active ? 'mdi-checkbox-marked-circle-outline' : 'mdi-close-circle-outline' }}
        </v-icon>
      </template>
    </v-data-table>

    <v-dialog v-model="dialog" persistent
              max-width="400px">
      <v-card>
        <v-toolbar dark flat color="primary" height="50">
          <v-btn icon dark @click="dialog=false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>
            Category
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark text>
              Save
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-text-field label="RU*" required
                          v-model="category.ru"/>
            <v-text-field label="EN"
                          v-model="category.en"/>
            <v-checkbox
                label="Active"
                v-model="category.active"/>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

  </v-card>
</template>

<script>
export default {
  name: "index",

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
      categories: [],
      dialog    : false,
      category  : {
        ru    : null,
        en    : null,
        active: true
      }
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
    },

    /**
     * @param item
     */
    edit(item) {
      this.category = Object.assign({}, item)
      this.dialog = true
    },

    add() {
      this.category = {
        active: true
      }
      this.dialog = true
    }
  }
}
</script>