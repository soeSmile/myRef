<template>
  <nav class="sm-menu"
       :class="{ 'active' : show }">
    <div class="sm-flex middle sm-p-5"
         :class="show ? 'right' : 'center'">
      <i @click="show = !show"
         class="mdi mdi-menu sm-link sm-fnt size-4 sm-color-alert"></i>
    </div>

    <div v-if="$store.getters['auth/isAuth']">
      <div class="sm-menu-item sm-flex middle" :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-account'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ user.name }}
        </div>
      </div>

      <div @click="$store.dispatch('auth/logout')"
           class="sm-menu-item link sm-flex middle sm-link"
           :class="show ? 'left' : 'center'">
        <div class="icon">
          <i class='mdi mdi-location-exit'></i>
        </div>
        <div class="text" :class="{ 'active' : show }">
          {{ menu.exit }}
        </div>
      </div>

      <div class="sm-line sm-m-2"></div>

      <div v-if="$store.getters['auth/isClient']"
           class="sm-bg-user-fon">
        <site-menu-user :show="show"/>
      </div>

      <div v-if="$store.getters['auth/isAdmin']"
           class="sm-bg-user-fon">
        <n-link class="sm-menu-item sm-flex middle"
                :class="show ? 'left' : 'center'"
                to="/admin">
          <div class="icon">
            <i class="mdi mdi-security"></i>
          </div>
          <div class="text"
               :class="{ 'active' : show }">
            Admin Zone
          </div>
        </n-link>
      </div>
    </div>

    <div v-else>
      <site-menu-auth :show="show"/>
    </div>

    <site-menu-main :show="show"/>

  </nav>
</template>

<script>

import siteMenuMain from "./siteMenu/siteMenuMain";
import SiteMenuAuth from "./siteMenu/siteMenuAuth";
import SiteMenuUser from "./siteMenu/siteMenuUser";

export default {
  name: "siteMenu",

  components: {
    SiteMenuUser,
    SiteMenuAuth,
    siteMenuMain
  },

  data() {
    return {
      show: false,
      menu: {
        exit: 'Выход'
      }
    }
  },

  computed: {
    user() {
      return this.$store.getters['auth/user'];
    }
  },
};
</script>