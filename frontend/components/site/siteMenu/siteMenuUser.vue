<template>
  <section>

    <div @click="addRef"
         class="sm-menu-item link sm-flex middle sm-link"
         :class="show ? 'left' : 'center'">
      <div class="icon">
        <i class="mdi mdi-link"></i>
      </div>
      <div class="text"
           :class="{ 'active' : show }">
        Добавить закладку
      </div>
    </div>
    <div class="sm-menu-item link sm-flex middle sm-link"
         :class="show ? 'left' : 'center'">
      <div class="icon">
        <i class="mdi mdi-note"></i>
      </div>
      <div class="text"
           :class="{ 'active' : show }">
        Добавить заметку
      </div>
    </div>

  </section>
</template>

<script>

import addRef from "../../ref/addRef";

export default {
  name: "siteMenuUser",

  components: {
    addRef
  },

  props: {
    show: false
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

  methods: {
    /**
     * add ref
     */
    addRef() {
      this.$buefy.modal.open({
        parent      : this,
        component   : addRef,
        hasModalCard: true,
        canCancel   : false,
        fullScreen  : true
      })
    }
  },
};
</script>