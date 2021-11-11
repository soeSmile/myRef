const env = require('dotenv').config();

export default {
    env: env.parsed,

    head: {
        titleTemplate: 'myRef.top - %s',
        meta         : [
            {charset: 'utf-8'},
            {name: 'viewport', content: 'width=device-width, initial-scale=1'},
            {hid: 'description', name: 'description', content: ''}
        ],
        link         : [
            {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'}
        ]
    },

    generate: {
        crawler: false
    },

    loading: {
        color : '#d88844',
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
        '~/plugins/axios',
        '~/plugins/builder',
        '~/plugins/helper',
    ],

    components: true,

    modules: [
        '@nuxtjs/axios',
        'cookie-universal-nuxt',
        'vue2-editor/nuxt',
        ['nuxt-buefy', {css: false}],
        [
            '@rkaliev/nuxtjs-yandex-metrika',
            {
                id                 : 86397135,
                clickmap           : true,
                trackLinks         : true,
                accurateTrackBounce: true
            },
        ],
    ],

    axios: {
        baseURL: process.env.APP_URL,
        headers: {
            'Accept': 'application/json'
        }
    },

    build: {}
};
