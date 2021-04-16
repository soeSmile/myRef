<template>
  <v-app>
    <v-app-bar app dark
               extension-height="80"
               color="blue darken-4">
      <v-container class="py-0 fill-height">

        <n-link to="/">
          <v-avatar class="mr-4"
                    color="grey darken-1"
                    size="32"/>
        </n-link>

        <v-toolbar-title class="mx-4">
          MyRef.top
        </v-toolbar-title>

        <v-select hide-no-data
                  hide-details
                  solo-inverted
                  flat
                  clearable
                  class="mx-4"
                  label="Катеории"
                  v-model="selectCategory"
                  :items="categories"
                  item-text="name"
                  item-value="id"/>

        <v-spacer/>

        <v-btn color="teal" class="mx-4"
               @click="dialog.show = true">
          Add Ref
          <v-icon right dark>
            mdi-plus
          </v-icon>
        </v-btn>

        <v-btn dark text :nuxt="true" to="search">
          <v-icon left>mdi-cloud-search-outline</v-icon>
          Advanced Search
        </v-btn>


        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn dark text
                   v-bind="attrs"
                   v-on="on">
              <v-icon left>mdi-account</v-icon>
              User Name
            </v-btn>
          </template>

          <v-list dense>
            <v-list-item-group color="primary">
              <v-list-item class="mx-2"
                           nuxt
                           :to="val.link"
                           v-for="(val, i) in items" :key="i">
                <v-list-item-icon>
                  <v-icon v-text="val.icon"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title v-text="val.text"></v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>

        </v-menu>

      </v-container>

    </v-app-bar>

    <v-main>
      <nuxt/>
    </v-main>

    <v-footer padless fixed>
      <v-col class="text-center" cols="12">
        {{ new Date().getFullYear() }} — <strong>myRef.top</strong>
      </v-col>
    </v-footer>

    <add-ref :dialog="dialog"/>
  </v-app>
</template>

<script>

import addRef from "../components/ref/addRef";

export default {
  name: "site",

  components: {
    addRef
  },

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      dialog        : {
        show: false
      },
      loading       : false,
      categories    : [
        {id: 1, name: 'Новости'},
        {id: 2, name: 'Наука'},
        {id: 3, name: 'Техника'},
        {id: 4, name: 'Бизнес и Работа'},
        {id: 5, name: 'Образование'},
        {id: 6, name: 'Медицина'},
        {id: 7, name: 'Юмор'},
        {id: 8, name: 'Еда'},
        {id: 9, name: 'Хобби и Досуг'},
        {id: 10, name: 'Музыка'},
        {id: 11, name: 'Кино'},
        {id: 12, name: 'Путешествия'},
        {id: 13, name: 'Покупки'},
        {id: 14, name: 'Домоводство'},
        {id: 15, name: 'Животные'},
        {id: 16, name: 'Дети'},
        {id: 17, name: 'Религия и Эзотерика'},
        {id: 18, name: 'Личное'},
        {id: 19, name: 'Посмотреть позже'}
      ],
      selectCategory: null,

      items: [
        {text: 'Real-Time', icon: 'mdi-clock', link: 'search'},
        {text: 'Audience', icon: 'mdi-account', link: 'search'},
        {text: 'Conversions', icon: 'mdi-flag', link: 'search'},
      ],
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>