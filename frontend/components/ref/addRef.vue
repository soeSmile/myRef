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
                 @click="dialog.show = false">
            Сохранить
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>

      <v-card-text>
        <v-text-field label="Url"
                      clearable
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
        date    : null
      },
      searchTag: null,
      tags     : []
    }
  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  watch: {},

  methods: {}
}
</script>