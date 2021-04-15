import { createStore } from 'vuex'

export default createStore({
    state: {
        isOpen: false,
    },

    mutations: {
        OPEN_CONTACT_MODAL: state => state.isOpen = true,
        CLOSE_CONTACT_MODAL: state => state.isOpen = false,
    },
})
