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
              <b-input v-model="tag.name">
              </b-input>
            </b-field>

            <b-field class="sm-mt-4"
                     :type="errors.active ? 'is-danger' : ''"
                     :message="errors.active">
              <b-switch v-model="tag.active">
                Активный
              </b-switch>
            </b-field>
          </div>
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
        name  : item.name,
        active: item.active,
      }
    }
  }
}
</script>