import { Module } from 'vuex'
import ContactModalState from '@/store/interfaces/ContactModalState'
import RootState from '@/store/interfaces/RootState'

const contactModal: Module<ContactModalState, RootState> = {
    state: {
        isOpen: false,
    },

    mutations: {
        OPEN_CONTACT_MODAL(state) {
            state.isOpen = true
        },
        CLOSE_CONTACT_MODAL(state) {
            state.isOpen = false
        },
    },

    actions: {
        openContactModal({ commit }) {
            commit('OPEN_CONTACT_MODAL')
        },
        closeContactModal({ commit }) {
            commit('CLOSE_CONTACT_MODAL')
        },
    },
}

export default contactModal