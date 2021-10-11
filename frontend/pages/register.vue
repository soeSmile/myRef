<template>
  <div class="sm-h-100 sm-flex center middle">
    <div class="sm-wpx-300 sm-flex col">
      <b-field label="Name"
               :type="errors.name ? 'is-danger' : ''"
               :message="errors.name">
        <b-input type="email"
                 v-model="user.name">
        </b-input>
      </b-field>

      <b-field label="Email"
               :type="errors.email ? 'is-danger' : ''"
               :message="errors.email">
        <b-input type="email"
                 v-model="user.email">
        </b-input>
      </b-field>

      <b-field label="Password"
               :type="errors.password ? 'is-danger' : ''"
               :message="errors.password">
        <b-input type="password"
                 v-model="user.password">
        </b-input>
      </b-field>

      <div class="sm-mt-8">
        <b-button class="sm-mr-2"
                  type="is-primary"
                  @click="register">
          Register
        </b-button>
        <b-button type="is-link"
                  @click="reset">
          Reset
        </b-button>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "register",

  layout: 'sitePage',

  data() {
    return {
      user  : {
        name    : null,
        email   : null,
        password: null
      },
      errors: {}
    }
  },

  methods: {
    reset() {
      this.user.name = null
      this.user.email = null
      this.user.password = null
      this.errors = {}
    },

    validForm() {
      let result = true

      for (let i in this.user) {
        if (!this.user[i]) {
          result = false
          this.$set(this.errors, i, 'Обязательное поле')
        }
      }

      return result
    },

    register() {
      if (this.validForm()) {

      }
    }
  }
}
</script>
