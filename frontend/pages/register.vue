<template>
  <div class="sm-h-100 sm-flex center middle">
    <div class="sm-wpx-300 sm-flex col">
      <p class="sm-mb-1 sm-color-color-2 sm-fnt bold">
        Имя
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Имя"
                  v-model="user.name"/>
        <div class="sm-form-error">
          {{ errors.name }}
        </div>
      </div>

      <p class="sm-mb-1 sm-mt-6 sm-color-color-2 sm-fnt bold">
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
                   @click="register">
          Вход
        </el-button>
        <el-button @click="reset">
          Сброс
        </el-button>
      </div>

      <div class="sm-form-input sm-mt-4">
        <div class="sm-form-error"></div>
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
