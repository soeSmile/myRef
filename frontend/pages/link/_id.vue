<template>
  <section class="sm-site-ref">
    <nav v-if="link.canEdit"
         class="sm-nav sm-bg-smoke sm-color-grey sm-mt-2 sm-mb-2">
      <div class="sm-nav-start"></div>
      <div class="sm-nav-end">
        <div v-if="!modeEdit"
             class="sm-nav-item sm-p-3 sm-link sm-hover-smoke sm-hover-bg-grey"
             @click="modeEdit = true">
          <i class="mdi mdi-pencil sm-mr-1"></i>
          <span>Редактировать</span>
        </div>
        <div v-if="modeEdit"
             @click="store"
             class="sm-nav-item sm-p-3 sm-link sm-hover-smoke sm-hover-bg-grey">
          <i class="mdi mdi-content-save sm-mr-1"></i>
          <span>Сохранить</span>
        </div>
        <div v-if="modeEdit"
             @click="cancelEdit"
             class="sm-nav-item sm-p-3 sm-link sm-hover-smoke sm-hover-bg-grey">
          <i class="mdi mdi-close sm-mr-1"></i>
          <span>Отмена</span>
        </div>
      </div>
    </nav>

    <img class="sm-site-ref-img"
         :src="link.img" alt="">
    <h1 class="sm-site-ref-title sm-site-ref-item">
      {{ link.title }}
    </h1>
    <div class="sm-site-ref-item">
      <div class="sm-fnt bold sm-color-grey">
        Описание
      </div>
      <div class="sm-mt-2">
        {{ link.desc }}
      </div>
    </div>
    <div class="sm-site-ref-item">
      <div class="sm-fnt bold sm-color-grey">
        Комментарий
      </div>
      <div class="sm-mt-2">
        {{ link.comment }}
      </div>
    </div>
    <div class="sm-site-ref-item">
      <div class="sm-fnt bold sm-color-grey">
        Ссылка
      </div>
      <div class="sm-mt-2">
        <a :href="link.url" target="_blank"
           class="sm-link-hover sm-color-color-1">
          {{ link.url }}
        </a>
      </div>
    </div>
    <div class="sm-site-ref-item">
      <div class="sm-fnt bold sm-color-grey">
        Тэги
      </div>
      <div class="sm-mt-2">
        <el-tag class="sm-mr-1"
                v-for="(val,key) in link.tags"
                :key="key">
          {{ val.name }}
        </el-tag>
      </div>
    </div>
    <div class="sm-site-ref-item">
      <div class="sm-fnt bold sm-color-grey">
        Категория
      </div>
      <div class="sm-mt-2">
        <section v-if="link.category">
          <i :class="'mdi '+ link.category.icon"></i>
          {{ link.category.name }}
        </section>
      </div>
    </div>
    <div class="sm-site-ref-item">
      <div class="sm-fnt bold sm-color-grey">
        Пользователь
      </div>
      <div class="sm-mt-2">
        {{ link.user ? link.user.name : '' }}
      </div>
    </div>

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
            this.copyLink = response.data.data;
          });
    }
  },


  props: {},

  data() {
    return {
      link    : {
        title   : null,
        desc    : null,
        url     : null,
        img     : null,
        category: {},
        user    : {},
        tags    : [],
        comment : null,
        canEdit : false,
      },
      copyLink: {},
      modeEdit: false,
    }
  },

  methods: {
    cancelEdit() {
      this.link = this.copyLink
      this.modeEdit = false
    },

    store() {

    },
  }
}
</script>