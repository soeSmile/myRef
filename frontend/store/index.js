export const state = () => (
    {}
);

export const mutations = {};

export const getters = {};

export const actions = {
    /**
     * @param commit
     * @param app
     * @param store
     * @param redirect
     * @return {Promise<void>}
     */
    async nuxtServerInit({commit}, {app, store, redirect}) {

        await store.dispatch('category/getCategories')

        // user && token
        const token = app.$cookies.get('token');
        console.log(token, document.cookie)

        if (token) {
            commit('auth/SET_TOKEN', {token: token});

            try {
                const user = await this.$axios.post('api/me');
                commit('auth/SET_USER', {user: user.data.data});
                console.log(user.data.data)
            } catch (e) {
                console.log(e)
                commit('auth/SET_TOKEN');
                redirect('/')
            }
        }
    },
};
