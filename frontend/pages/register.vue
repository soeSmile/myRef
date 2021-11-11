<template>
  <div class="sm-h-100 sm-flex center middle">
    <div class="sm-wpx-400 sm-flex col sm-p-4">
      <b-field label="Имя"
               :type="errors.name ? 'is-danger' : ''"
               :message="errors.name">
        <b-input type="text"
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

      <b-field label="Пароль"
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
          Регистрация
        </b-button>
        <b-button type="is-link"
                  @click="reset">
          Сброс
        </b-button>
      </div>

      <b-notification auto-close
                      v-model="isActive"
                      :duration="5000"
                      type="is-success"
                      class="sm-mt-4"
                      has-icon
                      aria-close-label="Close notification">
        {{ result }}
      </b-notification>
    </div>
  </div>
</template>

<script>

export default {
  name: "register",

  layout: 'sitePage',

  middleware: ['noAuth'],

  data() {
    return {
      user    : {
        name    : null,
        email   : null,
        password: null
      },
      errors  : {},
      result  : '',
      isActive: false
    }
  },

  methods: {
    reset() {
      this.user.name = null;
      this.user.email = null;
      this.user.password = null;
      this.errors = {};
    },

    validForm() {
      let result = true;
      this.errors = {};

      for (let i in this.user) {
        if (!this.user[i]) {
          result = false;
          this.$set(this.errors, i, 'Обязательное поле');
        }
      }

      return result;
    },

    register() {
      if (this.validForm()) {
        this.$axios.post('/api/register', this.user)
            .then((res) => {
              this.user = {};
              this.result = res.data.data;
              this.isActive = true;
            })
            .catch(err => {
              this.errors = err.response.data.errors;
            })
      }
    }
  }
}
</script>
