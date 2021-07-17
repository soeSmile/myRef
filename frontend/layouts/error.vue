<template>
  <v-app>

    <site-head/>

    <v-main>
      <v-container fill-height fluid>
        <v-row align="center" justify="center">

          <v-card flat color="transparent">
            <v-card-text>
              <div class="text-h1">
                Error 404
              </div>
            </v-card-text>
          </v-card>

        </v-row>
      </v-container>
    </v-main>

  </v-app>
</template>

<script>
import siteHead from "../components/site/siteHead";

export default {
  name: "error",

  components: {
    siteHead
  },

  head() {
    return {
      title: 'Error 404'
    }
  },
}
</script>
