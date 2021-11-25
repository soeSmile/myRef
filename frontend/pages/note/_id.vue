<template>
  <section>
    <div class="card sm-m-4">
      <nav v-if="note.canEdit"
           class="sm-nav sm-bg-user-fon sm-color-dark sm-p-2">
        <div class="sm-nav-start">
          <div v-if="!modeEdit"
               class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-dark"
               @click="runEdit">
            <i class="mdi mdi-pencil sm-mr-1"></i>
            <span>Редактировать</span>
          </div>
          <div v-if="modeEdit"
               @click="store"
               class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-dark">
            <i class="mdi mdi-content-save sm-mr-1"></i>
            <span>Сохранить</span>
          </div>
          <div v-if="modeEdit"
               @click="cancelEdit"
               class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-dark">
            <i class="mdi mdi-close sm-mr-1"></i>
            <span>Отмена</span>
          </div>
          <div v-if="modeEdit"
               @click="destroy"
               class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-dark">
            <i class="mdi mdi-delete sm-mr-1"></i>
            <span>Удалить</span>
          </div>
        </div>
      </nav>

      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <figure class="image sm-wpx-200">
              <img :src="getImage(note.img)" alt="">
            </figure>
            <b-field v-if="modeEdit"
                     class="file is-primary sm-mt-2">
              <b-upload v-model="image"
                        @input="updateImage(note.id)"
                        class="file-label">
              <span class="file-cta">
                  <b-icon class="file-icon"
                          icon="upload"></b-icon>
                  <span class="file-label">
                    Max 2Mb
                  </span>
              </span>
              </b-upload>
            </b-field>
            <p v-if="errors.image"
               class="help is-danger"
               v-html="$messageToStr(errors.image)">
            </p>
          </div>
          <div class="media-content">
            <b-input v-if="modeEdit"
                     v-model="note.title"/>
            <h1 v-else
                class="title is-4">
              {{ note.title }}
            </h1>
          </div>
        </div>

        <div class="content">

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
                       v-for="(val,key) in note.tags"
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
                     v-for="(val,key) in note.tags"
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
              <div v-if="copyNote.category"
                   class="sm-mb-2">
                <i :class="'mdi '+ copyNote.category.icon"></i>
                {{ copyNote.category.name }}
              </div>
              <b-field>
                <b-select placeholder="Выбор категории"
                          expanded
                          v-model="note.category">
                  <option v-for="val in categories"
                          :value="val"
                          :key="val.id">
                    {{ val.name }}
                  </option>
                </b-select>
              </b-field>
            </div>
            <div v-else-if="!modeEdit && note.category"
                 class="ref-content">
              <i :class="'mdi '+ note.category.icon"></i>
              {{ note.category.name }}
            </div>
          </div>

          <div class="sm-site-ref-item">
            <VueEditor v-if="modeEdit"
                       v-model="note.body"
                       :editorToolbar="customToolbar"/>
            <div v-else
                 v-html="note.body"></div>
          </div>

          <div class="sm-site-ref-item sm-flex middle">
            <a v-if="note.file"
               :href="'/sys/note/download/' + note.id"
               target="_blank">
              <b-button type="is-info"
                        icon-left="download">
                Скачать вложение
              </b-button>
            </a>

            <b-button v-if="modeEdit && note.file"
                      @click="destroyAttache"
                      class="sm-ml-1"
                      type="is-danger"
                      icon-left="close">
              Удалить
            </b-button>

            <b-field v-if="modeEdit"
                     class="file is-primary sm-ml-1"
                     :class="{'has-name': !!file}">
              <b-upload v-model="file"
                        class="file-label"
                        @input="uploadAttache">
            <span class="file-cta">
                <b-icon class="file-icon" icon="upload"></b-icon>
                <span class="file-label">
                  Загрузить файл (Max {{ Math.trunc($const.MAX_NOTE_FILE / 1024 / 1024) }}Mb)
                </span>
            </span>
                <span class="file-name" v-if="file">
                {{ file.name }}
            </span>
              </b-upload>
            </b-field>
          </div>

          <p v-if="errors.file"
             class="help is-danger"
             v-html="$messageToStr(errors.file)">
          </p>

          <div v-if="note.user"
               class="sm-site-ref-item">
            <div class="ref-title">
              Пользователь
            </div>
            <div class="ref-content">
              {{ note.user ? note.user.name : '' }}
            </div>
          </div>

          <div v-if="modeEdit"
               class="sm-site-ref-item sm-wpx-300">
            <b-field label="Дата напоминания">
              <b-datepicker
                  v-model="note.date"
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
              <b-switch v-model="note.flag"
                        :true-value="$const.FLAG_PUBLIC"
                        :false-value="$const.FLAG_PRIVAT">
                Публичная
              </b-switch>
            </b-field>
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
  name: "site_note_id",

  layout: 'site',

  head() {
    return {
      title: this.note.title
    }
  },

  async fetch() {
    if (this.$route.params.id) {
      await this.$axios.get('api/links/' + this.$route.params.id)
          .then(response => {
            this.note = response.data.data;
          });
    }
  },

  data() {
    return {
      loading      : false,
      note         : {
        title   : null,
        category: {},
        user    : {},
        tags    : [],
        date    : null,
        body    : null,
        flag    : null,
        type    : null,
        file    : null,
        canEdit : false
      },
      copyNote     : {},
      selectTag    : null,
      tags         : [],
      errors       : {},
      minDate      : new Date(),
      modeEdit     : false,
      customToolbar: [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{'header': 1}, {'header': 2}],
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],
        [{'indent': '-1'}, {'indent': '+1'}],
        [{'direction': 'rtl'}],
        [{'size': ['small', false, 'large', 'huge']}],
        [{'header': [1, 2, 3, 4, 5, 6, false]}],
        [{'color': []}, {'background': []}],
        [{'font': []}],
        [{'align': []}],
        ['clean']
      ],
      file         : null,
      image        : null
    }
  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  methods: {
    /**
     * edit
     */
    runEdit() {
      this.copyNote = JSON.parse(JSON.stringify(this.note));
      this.modeEdit = true
    },

    /**
     * cancel edit
     */
    cancelEdit() {
      this.note = Object.assign({}, this.copyNote);
      this.modeEdit = false;
      this.errors = {};
      this.file = null;
    },

    /**
     * store
     */
    store() {
      this.loading = true
      let method = 'post',
          link   = 'api/notes';

      if (this.note.id) {
        method = 'put';
        link = 'api/notes/' + this.note.id;
      }

      this.$axios[method](link, this.prepareData(this.note))
          .then(response => {

            if (method === 'post') {
              this.note = response.data.data;
              this.$router.replace('/note/' + response.data.data.id);
            }

            this.$message({
              message: 'Saved !',
              type   : 'success'
            })

            this.copyNote = JSON.parse(JSON.stringify(this.note));
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
      this.$buefy.dialog.confirm({
        title      : 'Удалить',
        message    : 'Удалить ссылку ?',
        confirmText: 'Да',
        type       : 'is-danger',
        hasIcon    : true,
        onConfirm  : () => {
          this.loading = true

          this.$axios.delete('api/links/' + this.note.id)
              .then(() => {
                this.$buefy.toast.open({
                  message: 'Success !',
                  type   : 'is-success'
                })
                this.$router.push('/');
              })
              .catch(e => {
                this.errors = e.response.data.errors;
                this.$buefy.toast.open({
                  type                    : 'is-danger',
                  dangerouslyUseHTMLString: true,
                  message                 : this.$messageToStr(this.errors),
                });
                this.cancelEdit();
              })
              .finally(() => {
                this.loading = false
                this.modeEdit = false
              });
        }
      });
    },

    /**
     * @return {{}}
     */
    prepareData(ref) {
      return {
        id        : ref.id,
        title     : ref.title,
        categoryId: ref.category.id,
        tags      : ref.tags.length === 0 ? null : ref.tags,
        date      : ref.date,
        body      : ref.body,
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
            .catch(() => {
            })
      }
    },

    /**
     * @param item
     */
    insertTag(item) {
      this.selectTag = null
      this.tags = []
      let id = this.note.tags.find(x => x.id === item.id)

      if (!id) {
        this.note.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeTag(key) {
      this.link.tags.splice(key, 1)
    },

    /**
     * upload attache
     * @param val
     */
    uploadAttache(val) {
      if (val.size > this.$const.MAX_NOTE_FILE) {
        this.errors.file = 'Размер больше ' + Math.trunc(this.$const.MAX_NOTE_FILE / 1024 / 1024) + 'Mb';
        return;
      }

      let formData = new FormData();
      formData.append('file', val);
      formData.append('id', this.note.id);

      this.loading = true;
      this.errors.file = null;

      this.$axios.post('api/notes/attache', formData)
          .then((res) => {
            this.$buefy.toast.open({
              message: 'Success !',
              type   : 'is-success'
            })
            this.note.file = res.data.data;
            this.file = null;
          })
          .catch(e => {
            this.errors = e.response.data.errors;
            this.$buefy.toast.open({
              type                    : 'is-danger',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            });
          })
          .finally(() => {
            this.loading = false
          });
    },

    /**
     * destroy attache
     */
    destroyAttache() {
      this.$buefy.dialog.confirm({
        title      : 'Удалить',
        message    : 'Удалить вложение?',
        confirmText: 'Да',
        type       : 'is-danger',
        hasIcon    : true,
        onConfirm  : () => {
          this.loading = true

          this.$axios.delete('api/notes/attache/' + this.note.id)
              .then(() => {
                this.$buefy.toast.open({
                  message: 'Success !',
                  type   : 'is-success'
                })
                this.note.file = null;
              })
              .catch(e => {
                this.errors = e.response.data.errors;
                this.$buefy.toast.open({
                  type                    : 'is-danger',
                  dangerouslyUseHTMLString: true,
                  message                 : this.$messageToStr(this.errors),
                });
              })
              .finally(() => {
                this.loading = false
              });
        }
      });
    },

    /**
     * @param img
     * @return {string}
     */
    getImage(img) {
      return img === 'note' ? '/note.jpg' : '/screen/' + img;
    },

    /**
     * @param id
     */
    updateImage(id) {
      if (this.image.size > this.$const.MAX_NOTE_FILE) {
        this.errors.image = 'Размер больше ' + Math.trunc(this.$const.MAX_NOTE_FILE / 1024 / 1024) + 'Mb';
        return;
      }

      let formData = new FormData();
      formData.append('image', this.image);
      formData.append('id', this.note.id);

      this.loading = true
      this.errors.image = null;

      this.$axios.post('api/images', formData)
          .then((res) => {
            this.$buefy.toast.open({
              message: 'Success !',
              type   : 'is-success'
            })
            this.note.img = res.data.data;
            this.copyNote.img = res.data.data;
            this.image = null;
          })
          .catch(e => {
            this.errors = e.response.data.errors;
            this.$buefy.toast.open({
              type                    : 'is-danger',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            });
          })
          .finally(() => {
            this.loading = false
          });
    },

    /**
     * @param id
     */
    destroyImage(id) {
      this.$buefy.dialog.confirm({
        title      : 'Удалить',
        message    : 'Удалить изображение?',
        confirmText: 'Да',
        type       : 'is-danger',
        hasIcon    : true,
        onConfirm  : () => {
          this.loading = true

          this.$axios.delete('api/images/' + this.note.id)
              .then(() => {
                this.$buefy.toast.open({
                  message: 'Success !',
                  type   : 'is-success'
                })
                this.note.img = 'note';
              })
              .catch(e => {
                this.errors = e.response.data.errors;
                this.$buefy.toast.open({
                  type                    : 'is-danger',
                  dangerouslyUseHTMLString: true,
                  message                 : this.$messageToStr(this.errors),
                });
              })
              .finally(() => {
                this.loading = false
              });
        }
      });
    }
  }
}
</script>