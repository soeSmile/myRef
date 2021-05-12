<template>
  <v-card>
    <v-app-bar flat dense>
      <v-btn text exact class="mx-2"
             to="/admin/tag">
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
              v-model="tag.name"
              label="Tag name"
              :error-messages="errors['name']"
              required/>
          <v-checkbox
              v-model="tag.active"
              label="Active"/>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
export default {
  name: "tag_id",

  layout: 'admin',

  head() {
    return {
      title: 'Tag'
    }
  },

  async fetch() {
    if (this.$route.params.id && this.$route.params.id !== 'new') {
      await this.$axios.get('api/tags/' + this.$route.params.id)
          .then(response => {
            this.tag = response.data.data;
          });
    }
  },

  props: {},

  data() {
    return {
      tag   : {
        name  : null,
        active: true
      },
      errors: {}
    }
  },

  methods: {
    /**
     * @param close
     */
    store(close = false) {
      let method = 'post',
          link   = 'api/tags';

      if (this.tag.id) {
        method = 'put';
        link = 'api/tags/' + this.tag.id;
      }

      this.$axios[method](link, this.prepareData(this.tag))
          .then(response => {
            if (close) {
              this.$router.push('/admin/tag/')
            } else if (method === 'post') {
              this.tag = response.data.data;
              this.$router.replace('/admin/tag/' + response.data.data.id);
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
        name  : item.name,
        active: item.active,
      }
    }
  }
}
</script>