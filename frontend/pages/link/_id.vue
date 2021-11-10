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
            <figure class="image is-128x128">
              <img :src="getImage(link.img)" alt="">
            </figure>
          </div>
          <div class="media-content">
            <b-input v-if="modeEdit"
                     v-model="link.title"/>
            <h1 v-else
                class="title is-4">
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
              <b-input v-if="modeEdit"
                       custom-class="sm-textarea sm-mb-2"
                       rows="2"
                       v-model="link.userDesc"
                       type="textarea"/>
              <p v-else>
                {{ link.userDesc }}
              </p>

              <b-input v-if="modeEdit"
                       custom-class="sm-textarea"
                       rows="2"
                       v-model="link.desc"
                       type="textarea"/>
              <p v-else>
                {{ link.desc }}
              </p>
            </div>
          </div>

          <div class="sm-site-ref-item">
            <div class="ref-title">
              Комментарий
            </div>
            <b-input v-if="modeEdit"
                     custom-class="sm-textarea"
                     rows="1"
                     v-model="link.comment"
                     type="textarea"/>
            <div v-else
                 class="ref-content">
              {{ link.comment ? link.comment : 'Нет' }}
            </div>
          </div>

          <div class="sm-site-ref-item">
            <div class="ref-title">
              Ссылка
            </div>
            <div class="ref-content">
              <b-input v-if="modeEdit"
                       v-model="link.url"/>
              <a v-else
                 :href="link.url"
                 target="_blank"
                 class="sm-link-hover sm-color-primary">
                {{ link.url }}
              </a>
            </div>

            <div class="sm-site-ref-item">
              <div class="ref-title">
                Тэги
              </div>
              <div v-if="modeEdit"
                   class="ref-content">
                <b-field>
                  <b-autocomplete placeholder="Выбрать тег"
                                  :loading="loading"
                                  v-model="selectTag"
                                  ref="autocomplete"
                                  :data="tags"
                                  @typing="getTags"
                                  @select="insertTag">
                    <template #empty>Нет данных по запросу: {{ selectTag }}</template>
                    <template slot-scope="props">
                      {{ props.option.name }}
                    </template>
                  </b-autocomplete>
                </b-field>
                <div class="sm-flex wrap sm-mt-2">
                  <b-tag class="sm-m-1"
                         v-for="(val,key) in link.tags"
                         :key="val.name"
                         type="is-warning"
                         closable
                         @close="removeTag(key)">
                    {{ val.name }}
                  </b-tag>
                </div>
              </div>
              <div v-else
                   class="ref-content">
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
              <div v-if="modeEdit"
                   class="ref-content">
                <div v-if="copyLink.category"
                     class="sm-mb-2">
                  <i :class="'mdi '+ copyLink.category.icon"></i>
                  {{ copyLink.category.name }}
                </div>
                <b-field>
                  <b-select placeholder="Выбор категории"
                            expanded
                            v-model="link.category">
                    <option v-for="val in categories"
                            :value="val"
                            :key="val.id">
                      {{ val.name }}
                    </option>
                  </b-select>
                </b-field>
              </div>
              <div v-else-if="!modeEdit && link.category"
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

            <div v-if="modeEdit"
                 class="sm-site-ref-item sm-wpx-300">
              <b-field label="Дата напоминания">
                <b-datepicker
                    v-model="link.date"
                    placeholder="Дата напоминания"
                    icon="calendar-today"
                    icon-right-clickable
                    trap-focus
                    :min-date="minDate">
                </b-datepicker>
              </b-field>
            </div>

            <div v-if="modeEdit"
                 class="sm-site-ref-item">
              <b-field class="sm-mt-8"
                       grouped>
                <b-switch v-model="link.cache"
                          class="sm-mr-4">
                  Кешировать
                </b-switch>
                <b-switch v-model="link.flag"
                          :true-value="2"
                          :false-value="1">
                  Публичная
                </b-switch>
              </b-field>
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

    <b-loading :is-full-page="false"
               v-model="loading"
               :can-cancel="false"/>
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

  data() {
    return {
      loading  : false,
      link     : {
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
      copyLink : {},
      selectTag: null,
      tags     : [],
      errors   : {},
      minDate  : new Date(),
      modeEdit : false,
    }
  },

  computed: {
    /**
     * категории
     * @return {array}
     */
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  methods: {
    /**
     * перевести в режим редактирования
     */
    runEdit() {
      this.copyLink = JSON.parse(JSON.stringify(this.link));
      this.modeEdit = true
    },

    /**
     * отмена редактирования
     */
    cancelEdit() {
      this.link = Object.assign({}, this.copyLink)
      this.modeEdit = false
    },

    /**
     * сохранить изменения
     */
    store() {
      this.loading = true

      this.$axios.put('api/links/' + this.link.id, this.prepareData(this.link))
          .then(() => {
            this.$buefy.toast.open({
              message: 'Saved !',
              type   : 'is-success'
            });

            this.copyLink = JSON.parse(JSON.stringify(this.link));
          })
          .catch(e => {
            this.errors = e.response.data.errors;
            this.$buefy.toast.open({
              type                    : 'is-danger',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            });
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
      this.$buefy.dialog.confirm({
        title      : 'Удалить',
        message    : 'Удалить ссылку ?',
        confirmText: 'Да',
        type       : 'is-danger',
        hasIcon    : true,
        onConfirm  : () => {
          this.loading = true

          this.$axios.delete('api/links/' + this.link.id)
              .then(() => {
                this.$buefy.toast.open({
                  message: 'Success !',
                  type   : 'is-success'
                })
                this.$router.push('/')
              })
              .catch(e => {
                this.errors = e.response.data.errors;
                this.$buefy.toast.open({
                  type                    : 'is-danger',
                  dangerouslyUseHTMLString: true,
                  message                 : this.$messageToStr(this.errors),
                })
                this.cancelEdit()
              })
              .finally(() => {
                this.loading = false
                this.modeEdit = false
              })
        }
      });
    },

    /**
     * @return {{}}
     */
    prepareData(ref) {
      return {
        id        : ref.id,
        url       : ref.url,
        desc      : ref.desc,
        categoryId: ref.category ? ref.category.id : null,
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
    removeTag(key) {
      this.link.tags.splice(key, 1)
    },

    /**
     * @param img
     * @return {string}
     */
    getImage(img) {
      return img ? '/screen/' + img : '/no-image.jpg'
    }
  }
}
</script>