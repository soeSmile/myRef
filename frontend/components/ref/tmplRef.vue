<template>
  <div class="sm-w-25 sm-p-2">
    <el-card shadow="hover">
      <img class="sm-ref-img"
           :src="myRef.img ? myRef.img : ''"
           alt="">
      <h4 class="sm-ref-title">
        {{ myRef.title }}
      </h4>

    </el-card>
  </div>
</template>

<script>
export default {
  name: "tmplRef",

  props: {
    myRef: {}
  },

  data() {
    return {}
  }
}
</script>