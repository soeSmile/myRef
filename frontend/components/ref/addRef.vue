<template>
  <el-dialog title="Добавить ссылку" :visible.sync="showAddRef.show">
    <el-form :model="myRef">
      <el-form-item label="Ссылка">
        <el-input v-model="myRef.url" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Категория">
        <el-select v-model="myRef.category"
                   filterable
                   placeholder="Категория">
          <el-option
              v-for="item in categories"
              :key="item.id"
              :label="item.name"
              :value="item.id">
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="Категория">
        <el-select class="sm-w-100"
                   v-model="selectTag"
                   filterable
                   remote
                   reserve-keyword
                   placeholder="Тэг"
                   :remote-method="getTags"
                   @change="insertTag"
                   :loading="loading">
          <el-option v-for="(item,k) in myRef.tags"
                     :key="item.name"
                     :label="item.name"
                     :value="item">
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="Дата напоминания">
        <el-date-picker
            v-model="myRef.date"
            type="date"
            format="dd-MM-yyyy"
            placeholder="Дата напоминания">
        </el-date-picker>
      </el-form-item>
      <el-form-item label="Кешировать">
        <el-switch v-model="myRef.cache"
                   active-color="#72670C">
        </el-switch>
      </el-form-item>
      <el-form-item label="Коментарий">
        <el-input type="textarea"
                  :rows="3"
                  placeholder="Коментарий"
                  resize="none"
                  v-model="myRef.comment">
        </el-input>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
    <el-button @click="showAddRef.show = false">
      Отмена
    </el-button>
    <el-button type="primary"
               @click="showAddRef.show = false">
      Сохранить
    </el-button>
  </span>
  </el-dialog>
</template>

<script>
export default {
  name: "addRef",

  props: {
    showAddRef: {}
  },

  data() {
    return {
      showDate : false,
      myRef    : {
        url     : null,
        category: null,
        tags    : [],
        date    : null,
        comment : null,
        cache   : false
      },
      selectTag: null,
      tags     : [],
      errors   : {}
    }

  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  watch: {
    searchTag: function (newVal) {
      if (newVal && newVal.length > 2) {
        this.getTags()
      }
    }
  },

  methods: {
    store() {
      this.$axios.post('api/links', this.prepareData(this.myRef))
          .then(response => {
            this.$toast.success({
              title  : 'Success',
              message: 'Saved',
            })
            this.dialog.show = false
            this.$store.dispatch('links/setUrl', {params: this.$route.query})
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$toast.error({
              title  : 'Error',
              useHtml: true,
              message: this.$messageToStr(this.errors),
            })
          });
    },

    /**
     * @return {{}}
     */
    prepareData(ref) {
      return {
        url       : ref.url,
        categoryId: ref.category,
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
      this.$axios.get('/api/tags', {params: {tag: tag}})
          .then(response => {
            this.tags = response.data.data;
          })
          .catch(error => {
          })
    },

    /**
     * @param item
     */
    insertTag(item) {
      this.selectTag = null
      let id = this.request.tags.find(x => x.id === item.id)

      if (!id) {
        this.request.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeFromTags(key) {
      this.request.tags.splice(key, 1)
    },
  }
}
</script>