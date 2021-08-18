const env = require('dotenv').config();

export default {
    env: env.parsed,

    head: {
        titleTemplate: 'myRef.top - %s',
        meta         : [
            {charset: 'utf-8'},
            {name: 'viewport', content: 'width=device-width, initial-scale=1'},
            {hid: 'description', name: 'description', content: ''},
            {name: 'mailru-domain', content: 'HPz2i5mdR0UJqUc5'}
        ],
        link         : [
            {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'}
        ]
    },

    generate: {
        crawler: false
    },

    loading: {
        color : '#0589bd',
        height: '3px',
    },

    router: {
        linkExactActiveClass: 'is-active',
        prefetchLinks       : false
    },

    cache: false,

    css: [
        {
            src : "~/assets/scss/app.scss",
            lang: "scss",
        },
        '@mdi/font/css/materialdesignicons.min.css'
    ],

    plugins: [
        '~/plugins/auth',
        '~/plugins/axios',
        '~/plugins/builder',
        '~/plugins/mixin',
        '~/plugins/helper',
        '~/plugins/element',
    ],

    components: true,

    modules: [
        '@nuxtjs/axios',
        'cookie-universal-nuxt',
    ],

    axios: {
        baseURL: process.env.APP_URL,
        headers: {
            'Accept': 'application/json'
        }
    },

    build: {}
};
