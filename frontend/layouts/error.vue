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

    <site-footer/>

  </v-app>
</template>

<script>
import siteHead from "../components/site/siteHead";
import siteFooter from "../components/site/siteFooter";

export default {
  name: "error",

  components: {
    siteHead,
    siteFooter
  },

  head() {
    return {
      title: 'Error 404'
    }
  },
}
</script>
