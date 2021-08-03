<template>
  <section>
    <nav class="sm-nav sm-bg-color-10 sm-color-color-9">
      <div class="sm-nav-start">
        <n-link to="/admin/user"
                class="sm-nav-item sm-p-4 sm-link-hover sm-hover-color-10 sm-hover-bg-color-9">
          <i class="mdi mdi-close sm-mr-1"></i>
          <span>Выход</span>
        </n-link>
        <div class="sm-nav-item sm-p-4 sm-link sm-hover-color-10 sm-hover-bg-color-9"
             @click="store(false)">
          <i class="mdi mdi-content-save sm-mr-1"></i>
          <span>Сохранить</span>
        </div>
        <div class="sm-nav-item sm-p-4 sm-link sm-hover-color-10 sm-hover-bg-color-9"
             @click="store(true)">
          <i class="mdi mdi-content-save-move sm-mr-1"></i>
          <span>Сохранить и выйти</span>
        </div>
      </div>
    </nav>

    <div class="sm-mt-8 sm-wpx-400 sm-flex col">
      <p class="sm-mb-1 sm-color-dark">
        Имя
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Имя"
                  v-model="user.name"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.name)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        E-mail
      </p>
      <div class="sm-form-input">
        <el-input placeholder="E-mail"
                  v-model="user.email"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.email)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Пароль
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Пароль"
                  show-password
                  v-model="user.password"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.password)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Подтверждён
      </p>
      <div class="sm-form-input">
        <el-switch v-model="user.confirm"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.confirm)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Временная зона
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Временная зона"
                  v-model="user.timeZone"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.timeZone)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Роль
      </p>
      <div class="sm-form-input">
        <el-select v-model="user.role"
                   placeholder="Роль">
          <el-option v-for="item in roles"
                     :key="item"
                     :label="item"
                     :value="item">
          </el-option>
        </el-select>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.role)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Показывать пользователя
      </p>
      <div class="sm-form-input">
        <el-switch v-model="user.show"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.show)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Ссылка пользователя
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Ссылка пользователя"
                  v-model="user.link"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.link)">
        </div>
      </div>
    </div>

  </section>
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

            this.$message({
              message: 'Saved !',
              type   : 'success'
            })
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$message({
              type                    : 'error',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            })
          });
    },

    /**
     * @param item
     * @return {{}}
     */
    prepareData(item) {
      return {
        id      : item.id,
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