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
                  v-model="myNote.categoryId">
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

      <b-field label="Название заметки"
               :message="errors.title"
               :type="{'is-danger' : errors.title}">
        <b-input custom-class="sm-textarea"
                 required
                 rows="1"
                 v-model="myNote.title"
                 type="textarea"/>
      </b-field>

      <b-field label="Заметка">
        <VueEditor v-model="myNote.body"
                   :editorToolbar="customToolbar"/>
      </b-field>

      <p v-if="errors.file"
         class="help is-danger">
        {{ errors.file }}
      </p>
      <b-field class="file is-primary"
               :class="{'has-name': !!myNote.file}">
        <b-upload v-model="myNote.file"
                  class="file-label">
          <span class="file-cta">
            <b-icon class="file-icon"
                    icon="upload"/>
            <span class="file-label">
              Загрузить файл (Max {{ Math.trunc(maxFile / 1024 / 1024) }}Mb)
            </span>
          </span>
          <span class="file-name"
                v-if="myNote.file">
            {{ myNote.file.name }}
          </span>
        </b-upload>
        <b-button v-if="myNote.file"
                  @click="myNote.file=null"
                  class="sm-ml-1"
                  type="is-warning"
                  icon-right="close"/>
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
      maxFile      : 2097152,
      myNote       : {
        categoryId: null,
        tags      : [],
        date      : null,
        comment   : null,
        flag      : 1,
        title     : null,
        type      : 2,
        body      : null,
        file      : null
      },
      selectTag    : null,
      tags         : [],
      errors       : {},
      minDate      : new Date(),
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
     * @return {boolean}
     */
    valid() {
      this.errors = {}

      for (let i in this.myNote) {
        switch (i) {
          case 'title': {
            if (!this.myNote[i]) {
              this.errors[i] = 'Поле обязательное';
            }
            break;
          }
          case 'file': {
            if (this.myNote[i] && this.myNote[i].size > this.maxFile) {
              this.errors[i] = 'Размер больше' + Math.trunc(this.maxFile / 1024 / 1024) + 'Mb';
            }
            break;
          }
        }
      }

      return Object.keys(this.errors).length === 0;
    },

    /**
     * store
     */
    store() {
      if (this.valid()) {
        this.loading = true

        this.$axios.post('api/notes', this.prepareData(this.myNote))
            .then(() => {
              this.$buefy.toast.open({
                message: 'Saved !',
                type   : 'is-success'
              });

              this.$emit('close');
              this.$store.dispatch('links/setUrl', {params: this.$route.query});
            })
            .catch(err => {
              this.errors = err.response.data.errors;

              this.$buefy.toast.open({
                type                    : 'is-danger',
                dangerouslyUseHTMLString: true,
                message                 : this.$messageToStr(this.errors),
              });
            })
            .finally(() => {
              this.loading = false
            })
      }
    },

    /**
     * @param note
     * @return {FormData}
     */
    prepareData(note) {
      let fromData = new FormData();

      for (let i in note) {
        if (note[i]) {
          let data = note[i];

          if (note[i] instanceof Array) {
            data = JSON.stringify(note[i]);
          }
          fromData.append(i, data);
        }
      }

      return fromData;
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