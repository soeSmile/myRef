<template>
  <nav class="sm-nav sm-mt-4 sm-p-2">
    <div class="sm-nav-start"></div>
    <div class="sm-nav-center"></div>
    <div class="sm-nav-end">
      <div class="sm-nav-item">
        <button class="sm-button-site sm-bg-color-7 sm-color-white"
                @click="showAddRef.show = true">
          <i class="mdi mdi-plus-box sm-mr-1"></i>
          Закладку
        </button>
      </div>
      <div class="sm-nav-item">
        <button class="sm-button-site sm-bg-color-9 sm-color-white">
          <i class="mdi mdi-plus-box sm-mr-1"></i>
          Заметку
        </button>
      </div>
    </div>

    <add-ref :show-add-ref="showAddRef"/>
  </nav>
</template>

<script>

import addRef from "../../ref/addRef";

export default {
  name: "siteControl",

  components: {
    addRef
  },

  data() {
    return {
      showAddRef: {
        show: false
      }
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>