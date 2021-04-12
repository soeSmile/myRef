import Vue from 'vue';


/**
 * language mixin
 */
Vue.mixin(
    {
        computed: {
            isAdmin() {
                return this.$store.getters['auth/user'].isAdmin || false;
            },
            isClient() {
                return this.$store.getters['auth/user'].isClient || false;
            },
            userLink() {
                return this.$store.getters['auth/link'] || '/';
            }
        },
        methods : {}
    });
