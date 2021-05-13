<template>
  <v-card>
    <v-app-bar flat dense>
      <v-btn text exact class="mx-2"
             to="/admin/user">
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
              v-model="user.name"
              label="User name"
              :error-messages="errors['name']"
              required/>
          <v-text-field
              v-model="user.email"
              label="User email"
              :error-messages="errors['email']"
              required/>
          <v-text-field
              v-model="user.password"
              label="User password"
              :error-messages="errors['password']"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :type="showPassword ? 'text' : 'password'"
              @click:append="showPassword = !showPassword"
              required/>
          <v-checkbox
              v-model="user.confirm"
              label="Confirm"/>
          <v-text-field
              v-model="user.timeZone"
              label="User time zone"
              :error-messages="errors['timeZone']"
              required/>
          <v-select
              :items="roles"
              v-model="user.role"
              label="User role"
              :error-messages="errors['role']"
              required/>
          <v-checkbox
              v-model="user.show"
              :error-messages="errors['show']"
              label="Show name"/>
          <v-text-field
              v-model="user.link"
              label="User link"
              :error-messages="errors['link']"/>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
export default {
  name: "user_id",

  layout: 'admin',

  head() {
    return {
      title: 'User'
    }
  },

  async fetch() {
    if (this.$route.params.id && this.$route.params.id !== 'new') {
      await this.$axios.get('api/users/' + this.$route.params.id)
          .then(response => {
            this.user = response.data.data;
          });
    }
  },

  props: {},

  data() {
    return {
      showPassword: false,
      user        : {
        name    : null,
        email   : null,
        password: null,
        confirm : false,
        timeZone: 3,
        role    : 'new',
        show    : false,
        link    : null
      },
      roles       : ['new', 'admin', 'client'],
      errors      : {}
    }
  },

  methods: {
    /**
     * @param close
     */
    store(close = false) {
      let method = 'post',
          link   = 'api/users';

      if (this.user.id) {
        method = 'put';
        link = 'api/users/' + this.user.id;
      }

      this.$axios[method](link, this.prepareData(this.user))
          .then(response => {
            if (close) {
              this.$router.push('/admin/user/')

            } else if (method === 'post') {

              this.user = response.data.data;
              this.$router.replace('/admin/user/' + response.data.data.id);
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
        name    : item.name,
        email   : item.email,
        password: item.password,
        confirm : item.confirm,
        timeZone: item.timeZone,
        role    : item.role,
        show    : item.show,
        link    : item.link
      }
    }
  }
}
</script>