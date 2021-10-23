<template>
  <section>
    <nav class="sm-nav sm-bg-white sm-color-grey sm-p-2">
      <div class="sm-nav-start">
        <n-link to="/admin/user"
                class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-close sm-mr-1"></i>
          <span>Выход</span>
        </n-link>
        <div class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary"
             @click="store(false)">
          <i class="mdi mdi-content-save sm-mr-1"></i>
          <span>Сохранить</span>
        </div>
        <div class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary"
             @click="store(true)">
          <i class="mdi mdi-content-save-move sm-mr-1"></i>
          <span>Сохранить и выйти</span>
        </div>
      </div>
    </nav>

    <div class="sm-p-4">

      <div class="card sm-wpx-400">
        <div class="card-content">
          <div class="content">
            <b-field label="Имя"
                     :type="errors.name ? 'is-danger' : ''"
                     :message="errors.name">
              <b-input v-model="user.name">
              </b-input>
            </b-field>

            <b-field label="E-mail"
                     :type="errors.email ? 'is-danger' : ''"
                     :message="errors.email">
              <b-input v-model="user.email"
                       type="email">
              </b-input>
            </b-field>

            <b-field label="Пароль"
                     :type="errors.password ? 'is-danger' : ''"
                     :message="errors.password">
              <b-input v-model="user.password"
                       type="password"
                       password-reveal>
              </b-input>
            </b-field>

            <b-field label="Роль"
                     :type="errors.role ? 'is-danger' : ''"
                     :message="errors.role">
              <b-select placeholder="Роль"
                        v-model="user.role">
                <option v-for="item in roles"
                        :key="item"
                        :value="item">
                  {{ item }}
                </option>
              </b-select>
            </b-field>

            <b-field class="sm-mt-4">
              <b-switch v-model="user.confirm">
                Подтверждён
              </b-switch>
            </b-field>

            <b-field label="Временная зона"
                     :type="errors.timeZone ? 'is-danger' : ''"
                     :message="errors.timeZone">
              <b-input v-model="user.timeZone">
              </b-input>
            </b-field>

            <b-field class="sm-mt-4">
              <b-switch v-model="user.show">
                Показывать пользователя
              </b-switch>
            </b-field>

            <b-field label="Ссылка пользователя"
                     :type="errors.link ? 'is-danger' : ''"
                     :message="errors.link">
              <b-input v-model="user.link">
              </b-input>
            </b-field>
          </div>
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

            this.$buefy.toast.open({
              message: 'Saved !',
              type   : 'is-success'
            });
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$buefy.toast.open({
              message: this.$messageToStr(this.errors),
              type   : 'is-danger'
            });
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