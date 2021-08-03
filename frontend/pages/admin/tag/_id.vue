<template>
  <section>
    <nav class="sm-nav sm-bg-color-10 sm-color-color-9">
      <div class="sm-nav-start">
        <n-link to="/admin/tag"
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
                  v-model="tag.name"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.name)">
        </div>
      </div>

      <p class="sm-mt-8 sm-mb-1 sm-color-dark">
        Активный
      </p>
      <div class="sm-form-input">
        <el-switch v-model="tag.active"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.active)">
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "tag_id",

  layout: 'admin',

  head() {
    return {
      title: 'Tag'
    }
  },

  async fetch() {
    if (this.$route.params.id && this.$route.params.id !== 'new') {
      await this.$axios.get('api/tags/' + this.$route.params.id)
          .then(response => {
            this.tag = response.data.data;
          });
    }
  },

  props: {},

  data() {
    return {
      tag   : {
        name  : null,
        active: true
      },
      errors: {}
    }
  },

  methods: {
    /**
     * @param close
     */
    store(close = false) {
      let method = 'post',
          link   = 'api/tags';

      if (this.tag.id) {
        method = 'put';
        link = 'api/tags/' + this.tag.id;
      }

      this.$axios[method](link, this.prepareData(this.tag))
          .then(response => {
            if (close) {
              this.$router.push('/admin/tag/')
            } else if (method === 'post') {
              this.tag = response.data.data;
              this.$router.replace('/admin/tag/' + response.data.data.id);
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
        id    : item.id,
        name  : item.name,
        active: item.active,
      }
    }
  }
}
</script>