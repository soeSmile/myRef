<template>
  <div class="card sm-wpx-300 sm-m-2"
       :class="{ 'sm-bg-user-fon' : myRef.flag === 1 }">

    <div class="card-content">
      <a :href="myRef.url"
         target="_blank"
         :title="myRef.title">
        <div class="media sm-ref-title">
          <div class="media-left">
            <figure class="image is-32x32">
              <img :src="myRef.img ? myRef.img : ''" alt="">
            </figure>
          </div>
          <div class="media-content">
            <h4 class="title is-6">
              {{ getTitle(myRef.title) }}
            </h4>
          </div>
        </div>
        <div class="content">
          <div class="sm-ref-desc">
            <p>{{ getDesc(myRef.userDesc) }}</p>
            <p>{{ getDesc(myRef.desc) }}</p>
          </div>

          <div class="sm-ref-category sm-my-2">
            <section v-if="myRef.category">
              <i :class="'mdi '+ myRef.category.icon"></i>
              {{ myRef.category.name }}
            </section>
          </div>
        </div>
      </a>

      <div class="sm-flex middle right">
        <n-link class="sm-ref-link sm-fnt w600"
                :to="'/link/' + myRef.id">
          Подробнее
        </n-link>
      </div>
    </div>

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
  },

  methods: {
    /**
     * @param title
     * @return {string}
     */
    getTitle(title) {
      return title ? title.trim().slice(0, this.$const.TITLE_LENGTH) + (title.length >= this.$const.TITLE_LENGTH ? ' ...' : '') : '';
    },

    /**
     * @param desc
     * @return {string}
     */
    getDesc(desc) {
      return desc ? desc.trim().slice(0, this.$const.DESC_LENGTH) + (desc.length >= this.$const.DESC_LENGTH ? ' ...' : '') : '';
    },
  }
}
</script>