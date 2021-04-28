<template>
  <v-container fill-height fluid>
    <v-row align="center" justify="center">

      <v-card flat width="320" color="transparent">
        <v-card-title>
          Ругистрация
        </v-card-title>
        <v-card-text>

          <v-form ref="reg"
                  v-model="valid"
                  lazy-validation>
            <v-text-field v-model="user.name"
                          :rules="required"
                          clearable
                          label="Имя"
                          required/>
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
                 @click="register">
            Регистрация
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
  name: "register",

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
        name    : null,
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
      this.$refs.reg.reset()
    },

    register() {
      if (this.valid) {

      }
    }
  }
}
</script>
