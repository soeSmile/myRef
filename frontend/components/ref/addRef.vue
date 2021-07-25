<template>
  <ui-modal :onClose="() => showAddRef.show = !showAddRef.show">

  </ui-modal>
</template>

<script>

import uiModal from "../ui/uiModal";

export default {
  name: "addRef",

  components: {
    uiModal
  },

  props: {
    showAddRef: {}
  },

  data() {
    return {
      showDate : false,
      myRef    : {
        url     : null,
        category: null,
        tags    : [],
        date    : null,
        comment : null,
        cache   : false
      },
      selectTag: null,
      tags     : [],
      errors   : {}
    }

  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  watch: {
    searchTag: function (newVal) {
      if (newVal && newVal.length > 2) {
        this.getTags()
      }
    }
  },

  methods: {
    store() {
      this.$axios.post('api/links', this.prepareData(this.myRef))
          .then(response => {
            this.$toast.success({
              title  : 'Success',
              message: 'Saved',
            })
            this.dialog.show = false
            this.$store.dispatch('links/setUrl', {params: this.$route.query})
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
     * @return {{}}
     */
    prepareData(ref) {
      return {
        url       : ref.url,
        categoryId: ref.category,
        tags      : ref.tags.length === 0 ? null : ref.tags,
        date      : ref.date,
        comment   : ref.comment,
        cache     : ref.cache
      }
    },

    /**
     * @param tag
     */
    getTags(tag) {
      this.$axios.get('/api/tags', {params: {tag: tag}})
          .then(response => {
            this.tags = response.data.data;
          })
          .catch(error => {
          })
    },

    /**
     * @param item
     */
    insertTag(item) {
      this.selectTag = null
      let id = this.request.tags.find(x => x.id === item.id)

      if (!id) {
        this.request.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeFromTags(key) {
      this.request.tags.splice(key, 1)
    },
  }
}
</script>