<template>
  <nav class="sm-nav sm-mt-4 sm-p-2">
    <div class="sm-nav-start"></div>
    <div class="sm-nav-center"></div>
    <div class="sm-nav-end">
      <div class="sm-nav-item">
        <el-button type="success"
                   @click="showAddRef.show = true">
          <i class="mdi mdi-plus-box sm-mr-1"></i>
          Закладку
        </el-button>
      </div>
      <div class="sm-nav-item">
        <el-button type="warning">
          <i class="mdi mdi-plus-box sm-mr-1"></i>
          Заметку
        </el-button>
      </div>
    </div>

    <add-ref v-if="showAddRef.show"
             :showAddRef="showAddRef"/>
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