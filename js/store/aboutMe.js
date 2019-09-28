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
        showModal({commit}) {
            commit('setVisibility', true)
        },
        hideModal({commit}) {
            commit('setVisibility', false)
        },
    },

    getters: {
        isVisibleModal: state => state.isVisible,
    },
}