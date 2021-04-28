export const state = () => (
    {
        token    : null,
        expiresIn: null,
        user     : {},
        errors   : {},
        link     : '/'
    }
);

export const mutations = {
    /**
     * set token
     * @param state
     * @param data
     */
    SET_TOKEN(state, data = {}) {
        state.token = data.token;
        state.expiresIn = data.expiresIn;
        // set site
        this.$axios.setToken(data.token, 'Bearer');
        // set cookie
        this.$cookies.set('token', data.token, {maxAge: data.expiresIn, path: '/'});
    },
    /**
     * set user
     * @param state
     * @param data
     * @constructor
     */
    SET_USER(state, data = {}) {
        state.user = data.user;
        state.link = data.user.type;
    },
    /**
     * set errors
     * @param state
     * @param errors
     * @constructor
     */
    SET_ERRORS(state, errors = {}) {
        state.errors = errors;
    },
    /**
     * clear user and token
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
    link    : s => s.link,
};

export const actions = {
    /**
     * login
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
     * logout
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
     * clear User
     * @param commit
     * @return {*|number}
     */
    clearUser({commit}) {
        commit('CLEAR_TOKEN');

        return this.$router.push('/')
    }
};
