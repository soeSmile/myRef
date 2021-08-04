<template>
  <section>
    <nav class="sm-nav sm-bg-color-10 sm-color-color-9">
      <div class="sm-nav-start">
        <n-link to="/admin/category"
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
        Имя RU
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Имя RU"
                  v-model="category.ru"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.ru)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Имя EN
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Имя EN"
                  v-model="category.en"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.en)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Иконка
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Иконка"
                  v-model="category.icon"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.icon)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Активный
      </p>
      <div class="sm-form-input">
        <el-switch v-model="category.active"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.active)">
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

            this.$toast.success({
              title  : 'Success',
              message: 'Saved',
            })
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$toast.error({
              title  : 'Error',
              useHtml: true,
              message: this.$messageToStr(this.errors),
            })
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