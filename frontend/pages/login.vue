<template>
  <div class="sm-h-100 sm-flex center middle">
    <div class="sm-wpx-300 sm-flex col">
      <p class="sm-mb-1 sm-color-color-2 sm-fnt bold">
        E-mail
      </p>
      <div class="sm-form-input">
        <el-input placeholder="E-mail"
                  v-model="user.email"/>
        <div class="sm-form-error">
          {{ errors.email }}
        </div>
      </div>

      <p class="sm-mb-1 sm-mt-6 sm-color-color-2 sm-fnt bold">
        Пароль
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Пароль"
                  v-model="user.password"
                  show-password/>
        <div class="sm-form-error">
          {{ errors.password }}
        </div>
      </div>

      <div class="sm-mt-8">
        <el-button type="primary"
                   @click="login">
          Вход
        </el-button>
        <el-button @click="reset">
          Сброс
        </el-button>
      </div>

      <div class="sm-form-input sm-mt-4">
        <div class="sm-form-error" v-html="this.error"></div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "login",

  layout: 'sitePage',

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