export const state = () => (
    {
        links   : [],
        paginate: {},
        current : 1
    }
)

export const getters = {
    links   : s => s.links,
    paginate: s => s.paginate,
    current : s => s.current
}

export const mutations = {
    /**
     * @param state
     * @param links
     * @constructor
     */
    SET_LINKS(state, links) {
        state.links = links;
    },

    /**
     * @param state
     * @param data
     * @constructor
     */
    SET_PAGINATE(state, data) {
        state.paginate = data
    },

    /**
     * @param state
     * @param data
     * @constructor
     */
    SET_CURRENT(state, data) {
        state.current = data
    }
}

export const actions = {
    /**
     * @param commit
     * @param state
     * @param data
     * @returns {Promise<void>}
     */
    async getLinks({commit, state}, data = {}) {
        try {
            const response = await this.$axios.get('api/links', {params: data});
            commit('SET_LINKS', response.data.data);
            if (response.data.meta) {
                commit('SET_PAGINATE', response.data.meta);
                commit('SET_CURRENT', response.data.meta.current_page);
            }
        } catch (e) {
        }
    }
}

