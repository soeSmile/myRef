<template>
  <v-dialog v-model="dialog.show"
            max-width="600px">
    <v-card>
      <v-card-title>
        <span class="headline">Add ref</span>
      </v-card-title>
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
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1"
               text
               @click="dialog.show = false">
          Close
        </v-btn>
        <v-btn
            color="blue darken-1"
            text
            @click="dialog.show = false">
          Save
        </v-btn>
      </v-card-actions>
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