<template>
  <section>
    <nav v-if="note.canEdit"
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
      loading  : false,
      note     : {
        title   : null,
        category: {},
        user    : {},
        tags    : [],
        date    : null,
        body    : null,
        flag    : null,
        type    : null,
        file    : null,
        canEdit : true
      },
      copyNote : {},
      selectTag: null,
      tags     : [],
      errors   : {},
      minDate  : new Date(),
      modeEdit : false,
    }
  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  methods: {
    runEdit() {
      this.copyNote = JSON.parse(JSON.stringify(this.note));
      this.modeEdit = true
    },

    cancelEdit() {
      if (this.$route.params.id === 'new') {
        this.$router.push('/')
      } else {
        this.note = Object.assign({}, this.copyNote)
        this.modeEdit = false
      }
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