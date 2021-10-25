<template>
  <div class="modal-card" style="width: 300px">
    <header class="modal-card-head">
      <p class="modal-card-title sm-ml-4">
        Добавить ссылку
      </p>

      <button
          type="button"
          class="delete"
          @click="$emit('close')"/>
    </header>

    <section class="modal-card-body">
      <b-field label="Имя ссылки">
        <b-input
            v-model="searchUrl.name"
            placeholder="Ссылка"
            required>
        </b-input>
      </b-field>
    </section>

    <footer class="modal-card-foot">
      <b-button
          label="Отмена"
          @click="$emit('close')"/>
      <b-button
          @click="store"
          label="Сохранить"
          type="is-primary"/>
    </footer>
  </div>
</template>

<script>
export default {
  name: "addUserLink",

  props: {
    searchUrl: {}
  },

  data() {
    return {};
  },

  methods: {
    /**
     * store user link
     */
    store() {
      let method = 'post',
          link   = 'api/user-links';

      if (this.searchUrl.id) {
        method = 'put';
        link = 'api/user-links/' + this.searchUrl.id;
      }

      this.$axios[method](link, this.prepareData(this.searchUrl))
          .then(response => {
            this.$buefy.toast.open({
              message: 'Saved !',
              type   : 'is-success'
            });

            if (method === 'post') {
              this.$store.commit('auth/SET_USER_LINKS', response.data.data)
            } else {
              this.$store.commit('auth/UPDATE_USER_LINKS', {...this.searchUrl})
            }
            this.$emit('close');
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$buefy.toast.open({
              type                    : 'is-danger',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            });
          });
    },

    /**
     * @param item
     * @return {{name, url}}
     */
    prepareData(item) {
      return {
        id  : item.id || null,
        name: item.name,
        link: item.link
      }
    }
  },
};
</script>