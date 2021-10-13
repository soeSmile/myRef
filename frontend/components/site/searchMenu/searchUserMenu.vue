<template>
  <section class="sm-menu-search-user">
    <div class="sm-bg-user-fon sm-p-4">

      <p class="sm-mb-2 sm-color-dark sm-fnt w600">
        Быстрый доступ
      </p>
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
export default {
  name: "searchUserMenu",

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

  watch: {},

  created() {
  },

  mounted() {
  },

  methods: {
    addSearchUrl() {
    },

    /**
     * @param key
     */
    editSearchUrl(key) {
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
        }
      })
    }
  },
};
</script>