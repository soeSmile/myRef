<template>
  <section class="sm-menu-search-user">
    <div class="sm-bg-user-fon sm-p-4">

      <div class="sm-mb-2 sm-color-dark sm-fnt w600 sm-flex middle wide">
        <h4>Быстрый доступ</h4>
        <b-button type="is-success"
                  size="is-small"
                  icon-right="plus"
                  @click="addSearchUrl"/>
      </div>
      <div @click="$store.dispatch('links/setUrl', {params: JSON.parse(val.link)})"
           class="item"
           v-for="(val,key) in user.links"
           :key="val.id">
        <i class="mdi mdi-close remove"
           @click.stop="deleteSearchUrl(key)"></i>
        <i class="mdi mdi-pencil edit"
           @click.stop="editSearchUrl(key)"></i>
        <div class="name">
          {{ val.name }}
        </div>
      </div>

      <b-field class="sm-mt-8">
        <b-checkbox type="is-warning"
                    v-model="request.owner">
          Только свои
        </b-checkbox>
      </b-field>
    </div>
    <div class="sm-line sm-mt-4 sm-mb-4"></div>
  </section>
</template>

<script>
import addUserLink from "../userLink/addUserLink";

export default {
  name: "searchUserMenu",

  components: {
    addUserLink
  },

  props: {
    request: {}
  },

  data() {
    return {};
  },

  computed: {
    user() {
      return this.$store.getters['auth/user'];
    }
  },

  methods: {
    /**
     * add user link
     */
    addSearchUrl() {
      const link = JSON.stringify(this.$route.query);

      this.$buefy.modal.open({
        parent      : this,
        component   : addUserLink,
        hasModalCard: true,
        canCancel   : false,
        props       : {
          searchUrl: {
            link: link,
            name: null
          }
        }
      })
    },

    /**
     * edit user search link
     * @param key
     */
    editSearchUrl(key) {
      const link = Object.assign({}, this.user.links[key])

      this.$buefy.modal.open({
        parent      : this,
        component   : addUserLink,
        hasModalCard: true,
        canCancel   : false,
        props       : {
          searchUrl: link
        }
      })
    },

    /**
     * @param key
     */
    deleteSearchUrl(key) {
      this.$buefy.dialog.confirm({
        title      : 'Удалить?',
        message    : 'Удалить ссылку быстрого доступа?',
        type       : 'is-danger',
        cancelText : 'Нет',
        confirmText: 'Да',
        hasIcon    : true,
        onConfirm  : () => {
          this.$axios.delete('api/user-links/' + this.user.links[key].id)
              .then(response => {
                this.$buefy.toast.open({
                  message: 'Saved !',
                  type   : 'is-success'
                });
                this.$store.commit('auth/REMOVE_USER_LINK', key)
              })
              .catch(e => {
                this.errors = e.response.data.errors;

                this.$buefy.toast.open({
                  type                    : 'is-danger',
                  dangerouslyUseHTMLString: true,
                  message                 : this.$messageToStr(this.errors),
                });
              });
        }
      })
    }
  },
};
</script>