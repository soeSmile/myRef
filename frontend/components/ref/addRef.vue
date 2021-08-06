<template>
  <ui-modal :onClose="() => showAddRef.show = !showAddRef.show"
            :wpx="600">
    <template slot="header">
      Добавить ссылку
    </template>
    <template slot="content">
      <div class="sm-flex col">
        <div class="sm-flex col sm-mb-2">
          <label class="sm-label">Ссылка</label>
          <el-input v-model="myRef.url"
                    autocomplete="off"
                    placeholder="Ссылка"/>
        </div>

        <div class="sm-flex col sm-mb-2">
          <label class="sm-label">Категория</label>
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
        </div>

        <div class="sm-flex col sm-mb-4">
          <label class="sm-label">Тэги</label>
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

          <div class="sm-mt-4" v-if="myRef.tags.length > 0">
            <el-tag class="sm-mr-1"
                    v-for="(val,key) in myRef.tags"
                    :key="key"
                    closable
                    @close="removeFromTags(key)">
              {{ val.name }}
            </el-tag>
          </div>
        </div>

        <div class="sm-flex middle row sm-mb-4">
          <label class="sm-label sm-mr-4">Дата напоминания</label>
          <el-date-picker
              v-model="myRef.date"
              type="date"
              format="dd-MM-yyyy"
              value-format="yyyy-MM-dd"
              placeholder="Дата напоминания"
              :picker-options="pickerOptions">
          </el-date-picker>
        </div>

        <div class="sm-flex middle row sm-mb-4">
          <label class="sm-label sm-mr-4">Кешировать</label>
          <el-switch v-model="myRef.cache">
          </el-switch>
        </div>

        <div class="sm-flex col sm-mb-2">
          <label class="sm-label">Коментарий</label>
          <el-input type="textarea"
                    :rows="3"
                    placeholder="Коментарий"
                    resize="none"
                    v-model="myRef.comment">
          </el-input>
        </div>

        <div class="sm-flex col sm-mb-2">
          <label class="sm-label">Статус</label>
          <el-select v-model="myRef.flag"
                     placeholder="Статус">
            <el-option v-for="val in flags"
                       :key="val"
                       :label="val"
                       :value="val">
            </el-option>
          </el-select>
        </div>

      </div>
    </template>
    <template slot="foot">
      <el-button type="primary"
                 @click="store"
                 :disabled="loading">
        Сохранить
      </el-button>
      <el-button @click="showAddRef.show = false"
                 :disabled="loading">
        Отмена
      </el-button>
    </template>
  </ui-modal>
</template>

<script>

import uiModal from "../ui/uiModal";

export default {
  name: "addRef",

  components: {
    uiModal
  },

  props: {
    showAddRef: {}
  },

  data() {
    return {
      loading      : false,
      showDate     : false,
      myRef        : {
        url     : null,
        category: null,
        tags    : [],
        date    : null,
        comment : null,
        cache   : false,
        flag    : null
      },
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

  watch: {
    searchTag: function (newVal) {
      if (newVal && newVal.length > 2) {
        this.getTags()
      }
    }
  },

  methods: {
    store() {
      this.loading = true

      this.$axios.post('api/links', this.prepareData(this.myRef))
          .then(response => {
            this.$message({
              message: 'Saved !',
              type   : 'success'
            })
            this.showAddRef.show = false
            this.$store.dispatch('links/setUrl', {params: this.$route.query})
          })
          .catch(e => {
            this.errors = e.response.data.errors;
            this.$message({
              type                    : 'error',
              dangerouslyUseHTMLString: true,
              message                 : this.$messageToStr(this.errors),
            })
          })
          .finally(() => {
            this.loading = false
          })
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
      let id = this.myRef.tags.find(x => x.id === item.id)

      if (!id) {
        this.myRef.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeFromTags(key) {
      this.myRef.tags.splice(key, 1)
    },
  }
}
</script>