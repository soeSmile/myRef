<template>
  <section>
    <div class="sm-bg-user-fon sm-p-4">
      <b-field>
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

  computed: {},

  watch: {},

  created() {
  },

  mounted() {
  },

  methods: {},
};
</script>