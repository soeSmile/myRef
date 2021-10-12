<template>
  <div class="sm-h-100 sm-flex center middle">
    <div class="sm-wpx-300 sm-flex col">
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
                  @click="login">
          Вход
        </b-button>
        <b-button type="is-link"
                  @click="reset">
          Сброс
        </b-button>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "login",

  layout: 'sitePage',

  middleware: ['noAuth'],

  props: {},

  data() {
    return {
      user  : {
        email   : null,
        password: null
      },
      errors: {}
    }
  },

  computed: {
    error() {
      return this.$messageToStr(this.$store.getters['auth/errors']);
    },
  },

  methods: {
    reset() {
      this.user.email = null
      this.user.password = null
      this.errors = {}
      this.$store.dispatch('auth/clearError')
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

    login() {
      if (this.validForm()) {
        this.$store.dispatch('auth/login', this.prepareData(this.user))
        this.reset()
      }
    },

    /**
     * @param item
     * @return {{password: (null|string|*), timeZone: number, email: (null|RegExp|string|*)}}
     */
    prepareData(item) {
      return {
        email   : item.email,
        password: item.password,
        timeZone: -new Date().getTimezoneOffset() / 60 || 0,
      }
    }
  }
}
</script>