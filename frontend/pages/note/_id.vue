<template>
  <section v-loading="loading"
           class="sm-site-ref">

    <nav v-if="note.canEdit"
         class="sm-nav sm-bg-smoke sm-color-grey sm-mt-2 sm-mb-2">
      <div class="sm-nav-start"></div>
      <div class="sm-nav-end">
        <div v-if="!modeEdit"
             class="sm-nav-item sm-p-3 sm-link sm-hover-smoke sm-hover-bg-grey"
             @click="true">
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
             @click="true"
             class="sm-nav-item sm-p-3 sm-link sm-hover-smoke sm-hover-bg-grey">
          <i class="mdi mdi-close sm-mr-1"></i>
          <span>Отмена</span>
        </div>
        <div v-if="modeEdit && this.$route.params.id !== 'new'"
             @click="true"
             class="sm-nav-item sm-p-3 sm-link sm-hover-smoke sm-hover-bg-grey">
          <i class="mdi mdi-delete sm-mr-1"></i>
          <span>Удалить</span>
        </div>
      </div>
    </nav>

    <div class="sm-mt-8 sm-flex col">
      <p class="sm-mb-1 sm-color-dark">
        Имя
      </p>
      <div class="sm-form-input">
        <el-input placeholder="Имя"
                  v-model="note.title"/>
        <div class="sm-form-error"
             v-html="$messageToStr(errors.name)">
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "site_note_id",

  layout: 'site',

  middleware: ['auth', 'authClient'],

  head() {
    return {
      title: this.note.title ? this.note.title : 'Добавить заметку'
    }
  },

  async fetch() {
    if (this.$route.params.id && this.$route.params.id !== 'new') {
      await this.$axios.get('api/notes/' + this.$route.params.id)
          .then(response => {
            this.note = response.data.data;
            this.modeEdit = false
          });
    }
  },

  props: {},

  data() {
    return {
      loading : false,
      note    : {
        title   : null,
        category: {},
        user    : {},
        ags     : [],
        date    : null,
        body    : null,
        flag    : null,
        canEdit : true
      },
      copyNote: {},
      modeEdit: true,
      errors  : {}
    }
  },

  computed: {},

  methods: {
    runEdit() {
      this.copyNote = JSON.parse(JSON.stringify(this.note));
      this.modeEdit = true
    },

    cancelEdit() {
      this.note = Object.assign({}, this.copyNote)
      this.modeEdit = false
    },

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
      this.$confirm('Удалить ссылку ?', 'Удалить', {
        confirmButtonText: 'OK',
        cancelButtonText : 'Cancel',
        type             : 'error'
      }).then(() => {
        this.loading = true

        this.$axios.delete('api/notes/' + this.note.id)
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
      let id = this.note.tags.find(x => x.id === item.id)

      if (!id) {
        this.note.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeFromTags(key) {
      this.note.tags.splice(key, 1)
    },
  }
}
</script>