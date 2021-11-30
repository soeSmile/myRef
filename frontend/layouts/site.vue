<template>
  <section class="sm-layout">

    <aside class="sm-layout-menu">
      <site-menu :show="showMainMenu"
                 @change="changeShowMainMenu"/>
      <search-menu/>
    </aside>

    <div @click="changeShowMainMenu(!showMainMenu)"
         class="sm-menu-bg"
         :class="showMainMenu ? 'active' : ''">
    </div>

    <section class="sm-layout-wrap">
      <header class="sm-layout-header">
        <nav class="sm-nav sm-menu-head">
          <div class="sm-nav-start">
            <div class="sm-flex middle left sm-px-4">
              <i @click="changeShowMainMenu"
                 class="mdi mdi-menu sm-link sm-fnt size-4 sm-color-danger"></i>
            </div>
          </div>
          <div class="sm-nav-center">
            <p class="sm-fnt bold">
              MyRef.top
            </p>
          </div>
          <div class="sm-nav-end">
            <div class="sm-flex middle right sm-px-4">
              <i @click="changeSearchMenu"
                 class="mdi mdi-magnify sm-link sm-fnt size-4 sm-color-danger"></i>
            </div>
          </div>
        </nav>
      </header>

      <div class="sm-layout-content">
        <nuxt/>
      </div>


      <footer class="sm-layout-footer"></footer>
    </section>

  </section>
</template>

<script>

import SiteMenu from "../components/site/siteMenu";
import SearchMenu from "../components/site/searchMenu";

export default {
  name: "site",

  components: {
    SiteMenu,
    SearchMenu
  },

  data() {
    return {
      showMainMenu  : false,
      showSearchMenu: true
    }
  },

  methods: {
    /**
     * main menu
     * @param val
     */
    changeShowMainMenu(val) {
      this.showMainMenu = val;
    },

    /**
     * search menu
     * @param val
     */
    changeSearchMenu(val) {
      this.showSearchMenu = val;
    }
  }
}
</script>