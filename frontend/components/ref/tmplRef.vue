<template>
  <div class="sm-ref card sm-wpx-300 sm-m-2 sm-p-2">
    <a :href="getLink(myRef)"
       target="_blank"
       :title="myRef.title">

      <h2 class="sm-ref-title sm-fnt bold sm-p-1">
        {{ getTitle(myRef.title) }}
      </h2>

      <div class="sm-ref-image"
           :style="getImage(myRef)">
      </div>
    </a>

    <div class="sm-ref-category">
      <n-link v-if="myRef.category"
              class="sm-p-2"
              :to="'/?type=3&cats=['+myRef.category.id+']'">
        <i :class="'mdi '+ myRef.category.icon"></i>
        {{ myRef.category.name }}
      </n-link>
    </div>

    <footer class="card-footer sm-mt-2">
      <div class="card-footer-item">
        <i class="mdi mdi-star-outline"></i>
      </div>
      <div class="card-footer-item">
        <i class="mdi mdi-eye-outline"></i>
      </div>
      <div class="card-footer-item">
        <i class="mdi mdi-comment-outline"></i>
      </div>
      <div class="card-footer-item">
        <n-link class="sm-ref-link sm-fnt w600"
                title="Подробнее"
                :to="getLocalLink(myRef)">
          <i class="mdi mdi-unfold-more-vertical"></i>
        </n-link>
      </div>
    </footer>
  </div>
</template>

<script>

export default {
  name: "tmplRef",

  props: {
    myRef: {}
  },

  data() {
    return {
      img: [
        'buf.jpg', 'lara.jpg', 'noimg.jpg', 'ya.jpg'
      ]
    }
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

    /**
     * @return {string}
     * @param myRef
     */
    getImage(myRef) {
      let image = myRef.img ? '/screen/' + myRef.img : '/no-image.jpg'

      if (myRef.type === this.$const.TYPE_NOTE) {
        image = myRef.img === 'note' ? '/note.jpg' : '/screen/' + myRef.img;
      }

      return 'background-image: url(\'' + image + '\');'
    },

    /**
     * @param myRef
     * @returns {string}
     */
    getLink(myRef) {
      let link = myRef.url;

      if (myRef.type === this.$const.TYPE_NOTE) {
        link = '/note/' + myRef.id;
      }

      return link;
    },

    /**
     * @param myRef
     * @returns {string}
     */
    getLocalLink(myRef) {
      let link = '/link/' + myRef.id;

      if (myRef.type === this.$const.TYPE_NOTE) {
        link = '/note/' + myRef.id;
      }

      return link;
    }
  }
}
</script>