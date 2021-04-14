<template>
  <v-card max-width="320"
          class="ma-4">
    <v-img height="150"
           :src="img[Math.floor(Math.random() * img.length)]">
    </v-img>

    <v-card-title>Cafe Badilico</v-card-title>

    <v-card-text>
      <v-row align="center"
             class="mx-0">
        <v-rating :value="4.5"
                  color="amber"
                  dense
                  half-increments
                  readonly
                  size="14"/>

        <div class="grey--text ml-4">
          4.5 (413)
        </div>
      </v-row>
    </v-card-text>

    <v-card-actions>
      <v-btn icon>
        <v-icon>mdi-pencil</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-bookmark</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-share-variant</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: "tmplRef",

  created() {
  },

  mounted() {
  },

  props: {},

  data() {
    return {
      img: [
        'https://cdn.vuetifyjs.com/images/cards/house.jpg',
        'https://cdn.vuetifyjs.com/images/cards/road.jpg',
        'https://cdn.vuetifyjs.com/images/cards/plane.jpg'
      ]
    }
  },

  computed: {},

  watch: {},

  methods: {
    reserve() {
      this.loading = true

      setTimeout(() => (this.loading = false), 2000)
    },
  }
}
</script>