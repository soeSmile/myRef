export const state = () => (
    {
        token    : null,
        expiresIn: null,
        user     : {},
        errors   : {}
    }
);

export const mutations = {
    /**
     * @param state
     * @param data
     */
    SET_TOKEN(state, data = {}) {
        state.token = data.token;
        state.expiresIn = data.expiresIn;
        // set site
        this.$axios.setToken(data.token, 'Bearer');
        // set cookie
        let maxAge = data.expiresIn ? data.expiresIn * 60 : -1;
        this.$cookies.set('token', data.token, {
            maxAge  : maxAge,
            path    : '/',
            sameSite: 'lax'
        });
    },

    /**
     * @param state
     * @param data
     * @constructor
     */
    SET_USER(state, data = {}) {
        state.user = data.user;
    },

    /**
     * @param state
     * @param data
     * @constructor
     */
    SET_USER_LINKS(state, data) {
        state.user.links.push(data)
    },

    /**
     * @param state
     * @param data
     * @constructor
     */
    UPDATE_USER_LINKS(state, data) {
        let index
        state.user.links.map(function (item, i) {
            if (item.id === data.id) index = i
        })
        state.user.links.splice(index, 1, data)
    },

    /**
     * @param state
     * @param key
     * @constructor
     */
    REMOVE_USER_LINK(state, key) {
        state.user.links.splice(key, 1)
    },

    /**
     * @param state
     * @param errors
     * @constructor
     */
    SET_ERRORS(state, errors = {}) {
        state.errors = errors;
    },

    /**
     * @param state
     * @constructor
     */
    CLEAR_TOKEN(state) {
        state.token = null;
        state.expiresIn = null;
        state.user = {};
        this.$cookies.remove('token', {path: '/'});
    }
};

export const getters = {
    user    : s => s.user,
    errors  : s => s.errors,
    hasToken: s => !!s.token,
    isAdmin : s => s.user.isAdmin || false,
    isClient: s => s.user.isClient || false,
    isAuth  : s => s.user.isAdmin || s.user.isClient,
    userLink: s => s.user.link || '/'
};

export const actions = {
    /**
     * @param commit
     * @param user
     */
    async login({commit}, user) {
        commit('SET_ERRORS', {});

        try {
            const response = await this.$axios.post('api/login', user);
            commit('SET_USER', response.data);
            commit('SET_TOKEN', response.data);

            return this.$router.push('/');
        } catch (e) {
            commit('SET_ERRORS', e.response.data.errors);
        }
    },

    /**
     * @param commit
     * @param redirect
     */
    async logout({commit}) {
        try {
            await this.$axios.post('api/logout');
            commit('CLEAR_TOKEN');

            return this.$router.push('/')
        } catch (e) {
            return this.$router.push('/')
        }
    },

    /**
     * @param commit
     * @return {*|number}
     */
    clearUser({commit}) {
        commit('CLEAR_TOKEN');

        return this.$router.push('/')
    },

    /**
     * @param commit
     */
    clearError({commit}) {
        commit('SET_ERRORS', {})
    }
};
