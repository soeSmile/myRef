<template>
  <section class="sm-p-4">
    <h1 class="sm-fnt bold size-4">
      {{ link.title }}
    </h1>
    <p class="sm-mt-4">
      {{ link.desc }}
    </p>
  </section>
</template>

<script>
export default {
  name: "site_link_id",

  layout: 'site',

  head() {
    return {
      title: this.link.title
    }
  },

  async fetch() {
    if (this.$route.params.id) {
      await this.$axios.get('api/links/' + this.$route.params.id)
          .then(response => {
            this.link = response.data.data;
          });
    }
  },


  props: {},

  data() {
    return {
      link: {
        title   : null,
        desc    : null,
        url     : null,
        img     : null,
        category: null,
        user    : null,
        tags    : [],
        comment : null,
        cache   : null
      }
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>