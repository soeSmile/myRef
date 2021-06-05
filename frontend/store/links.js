export const state = () => (
    {
        links  : [],
        request: {}
    }
)

export const getters = {
    links: s => s.links
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
    SET_REQUEST(state, data) {
        state.request = data;
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
            const response = await this.$axios.get('api/links', {params: this.$qBuilder(state.request, data)});
            commit('SET_LINKS', response.data.data);
        } catch (e) {
        }
    }
}

