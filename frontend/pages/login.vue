<template>
  <div class="sm-h-100 sm-flex center middle">
    <div class="sm-wpx-300 sm-flex col">
      <b-field label="Email"
               :type="errors.email ? 'is-danger' : ''"
               :message="errors.email">
        <b-input type="email"
                 required
                 v-model="user.email">
        </b-input>
      </b-field>

      <b-field label="Пароль"
               :type="errors.password ? 'is-danger' : ''"
               :message="errors.password">
        <b-input type="password"
                 required
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

      <b-notification
          class="sm-mt-4"
          v-if="Object.keys(errors).length > 0"
          type="is-danger"
          v-html="this.$messageToStr(errors)">
      </b-notification>
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
      user: {
        email   : null,
        password: null
      },
    }
  },

  computed: {
    errors() {
      return this.$store.getters['auth/errors'];
    },
  },

  methods: {
    reset() {
      this.user.email = null
      this.user.password = null
      this.$store.dispatch('auth/clearError')
    },

    login() {
      this.$store.dispatch('auth/login', this.prepareData(this.user))
      this.reset()
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