export const state = () => (
    {
        links   : [],
        paginate: {}
    }
)

export const getters = {
    links   : s => s.links,
    paginate: s => s.paginate
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
            if (response.data.meta) {
                commit('SET_PAGINATE', response.data.meta);
            }
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

