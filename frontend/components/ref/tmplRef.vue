<template>
  <div class="sm-ref card sm-wpx-300 sm-m-2"
       :style="getImage(myRef)">

    <a :href="getLink(myRef)"
       target="_blank"
       :title="myRef.title"
       class="sm-ref-content sm-hpx-350">

      <h4 class="sm-ref-title sm-fnt bold sm-mb-2">
        {{ getTitle(myRef.title) }}
      </h4>

      <div class="sm-ref-desc sm-my-2">
        <section v-if="myRef.type === 1">
          <p class="sm-mb-1">
            {{ getDesc(myRef.userDesc) }}
          </p>
          <p>{{ getDesc(myRef.desc) }}</p>
        </section>
        <section v-else>
          <p v-html="getDesc(myRef.body)"></p>
        </section>
      </div>

      <div class="sm-ref-category sm-my-2">
        <section v-if="myRef.category">
          <i :class="'mdi '+ myRef.category.icon"></i>
          {{ myRef.category.name }}
        </section>
      </div>
    </a>

    <div class="sm-flex middle right sm-py-2 sm-px-4">
      <n-link class="sm-ref-link sm-fnt w600"
              :to="'/link/' + myRef.id">
        Подробнее
      </n-link>
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

      if (myRef.type === 2) {
        image = '/note.jpg';
      }

      return 'background-image: url(\'' + image + '\');'
    },

    getLink(myRef) {
      let link = myRef.url;

      if (myRef.type === 2) {
        link = '/link/' + myRef.id;
      }

      return link;
    }
  }
}
</script>