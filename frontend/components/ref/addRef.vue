<template>
  <v-dialog v-model="dialog.show"
            max-width="600px">
    <v-card>
      <v-toolbar dark flat color="green" height="50">
        <v-btn icon dark
               @click="dialog.show = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title>
          Add ref
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn text
                 @click="dialog.show = false">
            Save
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>

      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field label="Url"
                            v-model="ref.url"/>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
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
      ref: {
        url: null
      }
    }
  },

  computed: {},

  watch: {},

  methods: {}
}
</script>