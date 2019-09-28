export default {
    state: {
        isVisible: false,
    },

    mutations: {
        setVisibility(state, payload) {
            state.isVisible = payload
        },
    },

    actions: {
        showAboutMeModal({commit}) {
            commit('setVisibility', true)
        },
        hideAboutMeModal({commit}) {
            commit('setVisibility', false)
        },
    },

    getters: {
        isVisibleModal: state => state.isVisible,
    },
}