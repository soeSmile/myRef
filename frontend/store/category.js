export const state = () => (
    {
        categories: []
    }
)

export const mutations = {
    /**
     * @param state
     * @param categories
     * @constructor
     */
    SET_CATEGORY(state, categories) {
        state.categories = categories;
    }
}

export const getters = {
    categories: s => s.categories
}

export const actions = {
    /**
     * @param commit
     * @returns {Promise<void>}
     */
    async getCategories({commit}) {
        try {
            const response = await this.$axios.get('api/categories');
            commit('SET_CATEGORY', response.data.data);
        } catch (e) {
        }
    }
}