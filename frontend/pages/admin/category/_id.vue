<template>
  <section>
    <nav class="sm-nav sm-bg-white sm-color-grey sm-p-2">
      <div class="sm-nav-start">
        <n-link to="/admin/category"
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
            <b-field label="Имя RU"
                     :type="errors.ru ? 'is-danger' : ''"
                     :message="errors.ru">
              <b-input v-model="category.ru">
              </b-input>
            </b-field>

            <b-field label="Имя EN"
                     :type="errors.en ? 'is-danger' : ''"
                     :message="errors.en">
              <b-input v-model="category.en">
              </b-input>
            </b-field>

            <b-field label="Иконка"
                     :type="errors.icon ? 'is-danger' : ''"
                     :message="errors.icon">
              <b-input v-model="category.icon">
              </b-input>
            </b-field>

            <b-checkbox v-model="category.active">
              Активный
            </b-checkbox>
          </div>
        </div>
      </div>

    </div>

  </section>
</template>

<script>
export default {
  name: "category_id",

  layout: 'admin',

  head() {
    return {
      title: 'Category'
    }
  },

  async fetch() {
    if (this.$route.params.id && this.$route.params.id !== 'new') {
      await this.$axios.get('api/categories/' + this.$route.params.id)
          .then(response => {
            this.category = response.data.data;
          });
    }
  },

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      category: {
        ru    : null,
        en    : null,
        active: true,
        icon  : null
      },
      errors  : {}
    }
  },

  methods: {
    /**
     * @param close
     */
    store(close = false) {
      let method = 'post',
          link   = 'api/categories';

      if (this.category.id) {
        method = 'put';
        link = 'api/categories/' + this.category.id;
      }

      this.$axios[method](link, this.prepareData(this.category))
          .then(response => {
            if (close) {
              this.$router.push('/admin/category/')
            } else if (method === 'post') {
              this.category = response.data.data;
              this.$router.replace('/admin/category/' + response.data.data.id);
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
        id    : item.id,
        ru    : item.ru,
        en    : item.en,
        active: item.active,
        icon  : item.icon
      }
    }
  }
}
</script>