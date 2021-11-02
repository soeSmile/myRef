<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <button
          type="button"
          class="delete"
          @click="$emit('close')"/>

      <p class="modal-card-title sm-ml-4">
        Добавить заметку
      </p>

      <button
          type="button"
          class="delete"
          @click="$emit('close')"/>
    </header>

    <section class="modal-card-body">
      <b-field custom-class="sm-color-dark sm-fnt w600"
               label="Выбор категории">
        <b-select placeholder="Выбор категории"
                  expanded
                  v-model="myNote.category">
          <option v-for="val in categories"
                  :value="val.id"
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
               v-for="(val,key) in myNote.tags"
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
                 v-model="myNote.userDesc"
                 type="textarea"/>
      </b-field>

      <b-field label="Заметка">
        <VueEditor v-model="myNote.body"
                   :editorToolbar="customToolbar"/>
      </b-field>

      <b-field label="Дата напоминания">
        <b-datepicker
            v-model="myNote.date"
            placeholder="Дата напоминания"
            icon="calendar-today"
            icon-right-clickable
            trap-focus
            :min-date="minDate">
        </b-datepicker>
      </b-field>

      <b-field class="sm-mt-8"
               grouped>
        <b-switch v-model="myNote.cache"
                  class="sm-mr-4">
          Кешировать
        </b-switch>
        <b-switch v-model="myNote.flag"
                  :true-value="2"
                  :false-value="1">
          Публичная
        </b-switch>
      </b-field>

      <b-field label="Комментарий">
        <b-input custom-class="sm-textarea"
                 rows="1"
                 v-model="myNote.comment"
                 type="textarea"/>
      </b-field>
    </section>

    <footer class="modal-card-foot">
      <b-button
          label="Отмена"
          @click="$emit('close')"/>
      <b-button
          @click="store"
          label="Сохранить"
          type="is-primary"/>
    </footer>

    <b-loading :is-full-page="true"
               v-model="loading"
               :can-cancel="false">
    </b-loading>
  </div>
</template>

<script>
export default {
  name: "addNote",

  data() {
    return {
      loadingTag   : false,
      loading      : false,
      showDate     : false,
      myNote       : {
        category: null,
        tags    : [],
        date    : null,
        comment : null,
        flag    : 1,
        userDesc: null,
        type    : 2,
        body    : ''
      },
      selectTag    : null,
      tags         : [],
      errors       : {},
      minDate      : new Date(),
      customToolbar: [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean']
      ]
    };
  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  watch: {},

  created() {
  },

  mounted() {
  },

  methods: {
    /**
     * store
     */
    store() {

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
                this.tags.push({id: tag, name: tag, new: true});
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
      let id = this.myNote.tags.find(x => x.id === item.id);

      if (!id) {
        this.myNote.tags.push(item);
      }
    },

    /**
     * @param key
     */
    removeTag(key) {
      this.myNote.tags.splice(key, 1);
    },
  },
};
</script>