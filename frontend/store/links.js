export const state = () => (
    {
        links: []
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
            const response = await this.$axios.get('api/links', {params: this.$qBuilder({}, data)});
            commit('SET_LINKS', response.data.data);
        } catch (e) {
        }
    },

    /**
     * @param commit
     * @param state
     * @param data
     */
    setUrl({commit, state}, data) {
        if (data.clear) {
            this.$router.push({path: '/', query: {}})
        } else {
            this.$router.push({path: '/', query: data.params})
        }

        this.dispatch('links/getLinks', data.params)
    }
}

