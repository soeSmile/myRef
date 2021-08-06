<template>
  <section class="sm-site-ref"
           v-loading="loading">
    <nav v-if="link.canEdit"
         class="sm-nav sm-bg-smoke sm-color-grey sm-mt-2 sm-mb-2">
      <div class="sm-nav-start"></div>
      <div class="sm-nav-end">
        <div v-if="!modeEdit"
             class="sm-nav-item sm-p-3 sm-link sm-hover-smoke sm-hover-bg-grey"
             @click="runEdit">
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

    <el-input v-if="modeEdit"
              v-model="link.title"/>
    <h1 v-else class="sm-site-ref-title sm-site-ref-item">
      {{ link.title }}
    </h1>

    <div class="sm-site-ref-item">
      <div class="title">
        Описание
      </div>
      <el-input v-if="modeEdit"
                class="sm-mt-2"
                type="textarea"
                :rows="3"
                resize="none"
                v-model="link.desc"/>
      <div v-else
           class="content">
        {{ link.desc }}
      </div>
    </div>

    <div v-if="link.comment"
         class="sm-site-ref-item">
      <div class="title">
        Комментарий
      </div>
      <el-input v-if="modeEdit"
                class="sm-mt-2"
                type="textarea"
                :rows="3"
                resize="none"
                v-model="link.comment"/>
      <div v-else
           class="content">
        {{ link.comment }}
      </div>
    </div>

    <div class="sm-site-ref-item">
      <div class="title">
        Ссылка
      </div>
      <el-input v-if="modeEdit"
                class="sm-mt-2"
                v-model="link.url"/>
      <div v-else
           class="content">
        <a :href="link.url" target="_blank"
           class="sm-link-hover sm-color-color-1">
          {{ link.url }}
        </a>
      </div>
    </div>

    <div class="sm-site-ref-item">
      <div class="title">
        Тэги
      </div>
      <div v-if="modeEdit" class="sm-mt-2">
        <el-select class="sm-w-100"
                   v-model="selectTag"
                   filterable
                   remote
                   reserve-keyword
                   placeholder="Тэг"
                   :remote-method="getTags"
                   @change="insertTag">
          <el-option v-for="(item,k) in tags"
                     :key="item.name"
                     :label="item.name"
                     :value="item">
          </el-option>
        </el-select>
        <div class="sm-mt-4" v-if="link.tags.length > 0">
          <el-tag class="sm-mr-1"
                  v-for="(val,key) in link.tags"
                  :key="key"
                  closable
                  @close="removeFromTags(key)">
            {{ val.name }}
          </el-tag>
        </div>
      </div>

      <div v-else
           class="content">
        <el-tag class="sm-mr-1"
                v-for="(val,key) in link.tags"
                :key="key">
          {{ val.name }}
        </el-tag>
      </div>
    </div>

    <div class="sm-site-ref-item">
      <div class="title">
        Категория
      </div>
      <div class="sm-mt-2"
           v-if="modeEdit">
        <el-select v-model="link.category"
                   value-key="id"
                   filterable
                   placeholder="Категория">
          <el-option
              v-for="item in categories"
              :key="item.id"
              :label="item.name"
              :value="item">
          </el-option>
        </el-select>
      </div>
      <div v-else-if="!modeEdit && link.category"
           class="content">
        <i :class="'mdi '+ link.category.icon"></i>
        {{ link.category.name }}
      </div>
    </div>

    <div class="sm-site-ref-item">
      <div class="title">
        Пользователь
      </div>
      <div class="content">
        {{ link.user ? link.user.name : '' }}
      </div>
    </div>

    <div v-if="modeEdit"
         class="sm-site-ref-item">
      <div class="sm-fnt bold sm-color-grey">
        Дата напоминания
      </div>
      <el-date-picker
          class="sm-mt-2"
          v-model="link.date"
          type="date"
          format="dd-MM-yyyy"
          value-format="yyyy-MM-dd"
          placeholder="Дата напоминания"
          :picker-options="pickerOptions">
      </el-date-picker>
    </div>

    <div v-if="modeEdit"
         class="sm-site-ref-item">
      <div class="title">
        Статус
      </div>
      <el-select v-model="link.flag"
                 placeholder="Статус">
        <el-option v-for="val in flags"
                   :key="val"
                   :label="val"
                   :value="val">
        </el-option>
      </el-select>
    </div>

    <div v-if="modeEdit"
         class="sm-site-ref-item">
      <div class="title">
        Кешировать
      </div>
      <el-switch class="sm-mt-2"
                 v-model="link.cache"/>
    </div>

    <div v-if="link.canEdit"
         class="sm-site-ref-item">
      <div class="title">
        Кеш
      </div>
      <div v-if="link.cache"
           class="content"
           v-html="link.cache.data"></div>
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
          });
    }
  },


  props: {},

  data() {
    return {
      loading      : false,
      link         : {
        title   : null,
        desc    : null,
        url     : null,
        img     : null,
        category: {},
        user    : {},
        tags    : [],
        comment : null,
        date    : null,
        cache   : false,
        canEdit : false,
        flag    : null
      },
      copyLink     : {},
      modeEdit     : false,
      selectTag    : null,
      tags         : [],
      flags        : ['privat', 'public'],
      errors       : {},
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() < Date.now();
        },
      }
    }
  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  methods: {
    runEdit() {
      this.copyLink = JSON.parse(JSON.stringify(this.link));
      this.modeEdit = true
    },

    cancelEdit() {
      this.link = Object.assign({}, this.copyLink)
      this.modeEdit = false
    },

    store() {
      this.loading = true

      this.$axios.put('api/links/' + this.link.id, this.prepareData(this.link))
          .then(response => {
            this.$message({
              message: 'Saved !',
              type   : 'success'
            })

            this.copyLink = JSON.parse(JSON.stringify(this.link));
          })
          .catch(e => {
            this.errors = e.response.data.errors;
            this.$message({
              type                    : 'error',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            })
            this.cancelEdit()
          })
          .finally(() => {
            this.loading = false
            this.modeEdit = false
          })
    },

    /**
     * @return {{}}
     */
    prepareData(ref) {
      return {
        id        : ref.id,
        url       : ref.url,
        categoryId: ref.category.id,
        tags      : ref.tags.length === 0 ? null : ref.tags,
        date      : ref.date,
        comment   : ref.comment,
        cache     : ref.cache
      }
    },

    /**
     * @param tag
     */
    getTags(tag) {
      if (tag.length >= this.$const.TAG_LENGTH) {
        this.tags = []

        this.$axios.get('/api/tags', {params: {tag: tag}})
            .then(response => {
              if (response.data.data.length > 0) {
                this.tags = response.data.data;
              } else {
                this.tags.push({id: tag, name: tag, new: true})
              }
            })
            .catch(error => {
            })
      }
    },

    /**
     * @param item
     */
    insertTag(item) {
      this.selectTag = null
      let id = this.link.tags.find(x => x.id === item.id)

      if (!id) {
        this.link.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeFromTags(key) {
      this.link.tags.splice(key, 1)
    },
  }
}
</script>