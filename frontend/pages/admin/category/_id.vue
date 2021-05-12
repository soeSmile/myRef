<template>
  <v-card>
    <v-app-bar flat dense>
      <v-btn text exact class="mx-2"
             to="/admin/category">
        <v-icon left>mdi-close</v-icon>
        Cancel
      </v-btn>
      <v-btn text exact class="mx-2"
             @click="store(false)">
        <v-icon left>mdi-content-save</v-icon>
        Save
      </v-btn>
      <v-btn text exact class="mx-2"
             @click="store(true)">
        <v-icon left>mdi-content-save-move</v-icon>
        Save and Close
      </v-btn>
    </v-app-bar>

    <v-container fluid>
      <v-row>
        <v-col cols="4">
          <v-text-field
              v-model="category.ru"
              label="Category name RU"
              :error-messages="errors['ru']"
              required/>
          <v-text-field
              v-model="category.en"
              label="Category name EN"
              :error-messages="errors['en']"
              required/>
          <v-text-field
              v-model="category.icon"
              label="MDI icon"
              :error-messages="errors['icon']"
              required/>
          <v-checkbox
              v-model="category.active"
              label="Active"/>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
export default {
  name: "category_id",

  layout: 'admin',

  head() {
    return {
      title: 'Category'
    }
  },

  async fetch() {
    if (this.$route.params.id && this.$route.params.id !== 'new') {
      await this.$axios.get('api/categories/' + this.$route.params.id)
          .then(response => {
            this.category = response.data.data;
          });
    }
  },

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      category: {
        ru    : null,
        en    : null,
        active: true,
        icon  : null
      },
      errors  : {}
    }
  },

  methods: {
    /**
     * @param close
     */
    store(close = false) {
      let method = 'post',
          link   = 'api/categories';

      if (this.category.id) {
        method = 'put';
        link = 'api/categories/' + this.category.id;
      }

      this.$axios[method](link, this.prepareData(this.category))
          .then(response => {
            if (close) {
              this.$router.push('/admin/category/')
            } else if (method === 'post') {
              this.category = response.data.data;
              this.$router.replace('/admin/category/' + response.data.data.id);
            }

            this.$toast.success({
              title  : 'Success',
              message: 'Saved',
            })
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$toast.error({
              title  : 'Error',
              useHtml: true,
              message: this.$messageToStr(this.errors),
            })
          });
    },

    /**
     * @param item
     * @return {{}}
     */
    prepareData(item) {
      return {
        id    : item.id,
        ru    : item.ru,
        en    : item.en,
        active: item.active,
        icon  : item.icon
      }
    }
  }
}
</script>