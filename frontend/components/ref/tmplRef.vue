<template>
  <div class="sm-ref sm-p-2">
    <el-card shadow="hover">
      <a :href="myRef.url" target="_blank"
         class="sm-flex top col">
        <img class="sm-ref-img"
             :src="myRef.img ? myRef.img : ''"
             alt="">
        <h4 class="sm-ref-title sm-mt-2">
          {{ myRef.title }}
        </h4>
      </a>
      <div class="sm-ref-line"></div>

      <div class="sm-ref-category">
        <section v-if="myRef.category">
          <i :class="'mdi '+ myRef.category.icon"></i>
          {{ myRef.category.name }}
        </section>
      </div>

      <div class="sm-nav">
        <div class="sm-nav-left"></div>
        <div class="sm-nav-center"></div>
        <div class="sm-nav-end">
          <div class="sm-nav-item">
            <n-link :to="'/link/' + myRef.id"
                    class="sm-hover-color-3 sm-link">
              Подробнее
            </n-link>
          </div>
        </div>
      </div>

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