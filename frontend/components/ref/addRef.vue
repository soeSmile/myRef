<template>
  <v-dialog v-model="dialog.show"
            max-width="600px">
    <v-card>
      <v-toolbar dark flat color="green"
                 height="50" class="mb-4">
        <v-btn icon dark
               @click="dialog.show = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title>
          Добавить ссылку
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn text
                 @click="store">
            Сохранить
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>

      <v-card-text>
        <v-text-field label="Url"
                      clearable
                      :error-messages="errors['url']"
                      v-model="myRef.url"/>
      </v-card-text>

      <v-expansion-panels accordion flat>
        <v-expansion-panel>
          <v-expansion-panel-header>
            Дополнительно
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-select :items="categories"
                      clearable
                      item-text="name"
                      item-value="id"
                      label="Категории"
                      v-model="myRef.category"/>

            <v-combobox
                v-model="myRef.tags"
                :items="tags"
                item-text="name"
                item-value="id"
                :search-input.sync="searchTag"
                hide-selected
                label="Теги"
                multiple
                clearable
                persistent-hint
                small-chips/>

            <v-menu v-model="showDate"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto">
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="myRef.date"
                    label="Дата напоминания"
                    prepend-icon="mdi-calendar"
                    clearable
                    readonly
                    v-bind="attrs"
                    v-on="on"/>
              </template>
              <v-date-picker v-model="myRef.date"
                             no-title
                             @input="showDate = false"/>
            </v-menu>
            <v-checkbox v-model="myRef.cache"
                        label="Кешировать"/>
            <v-textarea class="mt-4"
                        label="Коментарий"
                        clearable
                        no-resize
                        v-model="myRef.comment"/>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "addRef",

  created() {
  },

  mounted() {
  },

  props: {
    dialog: {}
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
      searchTag: null,
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
     * get tags
     */
    getTags() {
      this.$axios.get('/api/tags', {params: {tag: this.searchTag}})
          .then(response => {
            this.tags = response.data.data;
          })
          .catch(error => {
            console.log(error)
          })
    },
  }
}
</script>