<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">
        Добавить ссылку
      </p>
      <button
          type="button"
          class="delete"
          @click="$emit('close')"/>
    </header>

    <section class="modal-card-body">
      <b-field label="Ссылка">
        <b-input
            v-model="myRef.url"
            placeholder="Ссылка"
            required>
        </b-input>
      </b-field>

      <b-field custom-class="sm-color-dark sm-fnt w600"
               label="Выбор категории">
        <b-select placeholder="Выбор категории"
                  expanded
                  v-model="myRef.category">
          <option v-for="val in categories"
                  :value="val"
                  :key="val.id">
            {{ val.name }}
          </option>
        </b-select>
      </b-field>

      <b-field class="sm-mt-4"
               custom-class="sm-color-dark sm-fnt w600"
               label="Выбрать тег">
        <b-autocomplete placeholder="Выбрать тег"
                        :loading="loadingTag"
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
               v-for="(val,key) in myRef.tags"
               :key="val.name"
               type="is-warning"
               closable
               @close="removeTag(key)">
          {{ val.name }}
        </b-tag>
      </div>

      <b-field label="Описание">
        <b-input custom-class="sm-textarea"
                 rows="1"
                 v-model="myRef.desc"
                 type="textarea"/>
      </b-field>

      <b-field label="Дата напоминания">
        <b-datepicker
            v-model="myRef.date"
            placeholder="Дата напоминания"
            icon="calendar-today"
            icon-right-clickable
            trap-focus>
        </b-datepicker>
      </b-field>

      <b-field class="sm-mt-8"
               grouped>
        <b-switch v-model="myRef.cache"
                  class="sm-mr-4">
          Кешировать
        </b-switch>
        <b-switch v-model="myRef.flag"
                    true-value="2"
                    false-value="1">
          Публичная
        </b-switch>
      </b-field>

      <b-field label="Коментарий">
        <b-input custom-class="sm-textarea"
                 rows="1"
                 v-model="myRef.comment"
                 type="textarea"/>
      </b-field>

    </section>

    <footer class="modal-card-foot">
      <b-button
          label="Отмена"
          @click="$emit('close')"/>
      <b-button
          label="Сохранить"
          type="is-primary"/>
    </footer>
  </div>
</template>

<script>
export default {
  name: "addRef",

  props: {
    showAddRef: {}
  },

  data() {
    return {
      loadingTag: false,
      loading   : false,
      showDate  : false,
      myRef     : {
        url     : null,
        category: null,
        tags    : [],
        date    : null,
        comment : null,
        cache   : false,
        flag    : 1,
        desc    : null
      },
      selectTag : null,
      tags      : [],
      errors    : {},
    }

  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  methods: {
    /**
     * store ref
     */
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
        desc      : ref.desc,
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
      this.tags = []
      let id = this.myRef.tags.find(x => x.id === item.id)

      if (!id) {
        this.myRef.tags.push(item)
      }
    },

    /**
     * @param key
     */
    removeTag(key) {
      this.myRef.tags.splice(key, 1)
    },
  }
}
</script>