<template>
  <v-container fill-height fluid>
    <v-row align="center" justify="center">

      <v-card flat width="320" color="transparent">
        <v-card-title>
          Вход
        </v-card-title>
        <v-card-text>

          <v-form ref="login"
                  v-model="valid"
                  lazy-validation>
            <v-text-field v-model="user.email"
                          :rules="emailRules"
                          clearable
                          label="Почта"
                          required/>
            <v-text-field v-model="user.password"
                          type="password"
                          :rules="required"
                          clearable
                          label="Пароль"
                          required/>
          </v-form>

        </v-card-text>
        <v-card-actions>
          <v-btn color="primary"
                 @click="login">
            Вход
          </v-btn>
          <v-btn @click="reset">
            Сброс
          </v-btn>
        </v-card-actions>

      </v-card>

    </v-row>
  </v-container>
</template>

<script>

import authLoginSocial from "../components/auth/authLoginSocial";

export default {
  name: "login",

  layout: 'auth',

  components: {
    authLoginSocial
  },

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      valid     : true,
      user      : {
        email   : null,
        password: null
      },
      emailRules: [
        v => !!v || 'Обязательное поле',
        v => /.+@.+\..+/.test(v) || 'Не валидная почта',
      ],
      required  : [
        v => !!v || 'Обязательное поле',
      ]
    }
  },

  computed: {},

  watch: {},

  methods: {
    reset() {
      this.$refs.login.reset()
    },

    login() {
      if (this.valid) {
        this.$store.dispatch('auth/login', this.prepareData(this.user));
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