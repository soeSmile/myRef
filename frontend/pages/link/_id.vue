<template>
  <section>
    <nav v-if="link.canEdit"
         class="sm-nav sm-bg-white sm-color-grey sm-p-2">
      <div class="sm-nav-start">
        <div v-if="!modeEdit"
             class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary"
             @click="runEdit">
          <i class="mdi mdi-pencil sm-mr-1"></i>
          <span>Редактировать</span>
        </div>
        <div v-if="modeEdit"
             @click="store"
             class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-content-save sm-mr-1"></i>
          <span>Сохранить</span>
        </div>
        <div v-if="modeEdit"
             @click="cancelEdit"
             class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-close sm-mr-1"></i>
          <span>Отмена</span>
        </div>
        <div v-if="modeEdit"
             @click="destroy"
             class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-delete sm-mr-1"></i>
          <span>Удалить</span>
        </div>
      </div>
    </nav>

    <div class="card sm-m-4">
      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <figure class="image is-48x48">
              <img :src="link.img" alt="">
            </figure>
          </div>
          <div class="media-content">
            <h1 class="title is-4">
              {{ link.title }}
            </h1>
          </div>
        </div>

        <div class="content">

          <div class="sm-site-ref-item">
            <div class="ref-title">
              Описание
            </div>
            <div class="ref-content">
              <p>{{ link.userDesc }}</p>
              <p>{{ link.desc }}</p>
            </div>
          </div>

          <div class="sm-site-ref-item">
            <div class="ref-title">
              Комментарий
            </div>
            <div class="ref-content">
              {{ link.comment ? link.comment : 'Нет' }}
            </div>
          </div>

          <div class="sm-site-ref-item">
            <div class="ref-title">
              Ссылка
            </div>
            <div class="ref-content">
              <a :href="link.url" target="_blank"
                 class="sm-link-hover sm-color-primary">
                {{ link.url }}
              </a>
            </div>

            <div class="sm-site-ref-item">
              <div class="ref-title">
                Тэги
              </div>
              <div class="ref-content">
                <b-tag class="sm-mr-1"
                       type="is-warning"
                       v-for="(val,key) in link.tags"
                       :key="key">
                  {{ val.name }}
                </b-tag>
              </div>
            </div>

            <div class="sm-site-ref-item">
              <div class="ref-title">
                Категория
              </div>
              <div v-if="!modeEdit && link.category"
                   class="ref-content">
                <i :class="'mdi '+ link.category.icon"></i>
                {{ link.category.name }}
              </div>
            </div>

            <div v-if="link.user"
                 class="sm-site-ref-item">
              <div class="ref-title">
                Пользователь
              </div>
              <div class="ref-content">
                {{ link.user ? link.user.name : '' }}
              </div>
            </div>

            <div v-if="link.canEdit"
                 class="sm-site-ref-item">
              <div class="ref-title">
                Кеш
              </div>
              <div class="ref-content"
                   v-html="link.cache ? link.cache.data : 'Нет'"></div>
            </div>

          </div>
        </div>
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
      flags        : [
        {id: 'public', name: 'Публичная'},
        {id: 'privat', name: 'Приватная'},
      ],
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
     * delete link
     */
    destroy() {
      this.$confirm('Удалить ссылку ?', 'Удалить', {
        confirmButtonText: 'OK',
        cancelButtonText : 'Cancel',
        type             : 'error'
      }).then(() => {
        this.loading = true

        this.$axios.delete('api/links/' + this.link.id)
            .then(response => {
              this.$message({
                message: 'Saved !',
                type   : 'success'
              })
              this.$router.push('/')
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
      }).catch(() => {
      })
    },

    /**
     * @return {{}}
     */
    prepareData(ref) {
      return {
        id        : ref.id,
        url       : ref.url,
        desc      : ref.desc,
        categoryId: ref.category.id,
        tags      : ref.tags.length === 0 ? null : ref.tags,
        date      : ref.date,
        comment   : ref.comment,
        cache     : ref.cache,
        flag      : ref.flag
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
      this.tags = []
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
    }
  }
}
</script>