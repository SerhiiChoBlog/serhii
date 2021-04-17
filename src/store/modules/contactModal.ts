import { Module } from "vuex"

interface ContactModalState {
    isOpen: boolean
}

const contactModal: Module<ContactModalState, {}> = {
    state: {
        isOpen: false,
    },

    mutations: {
        OPEN_CONTACT_MODAL: state => state.isOpen = true,
        CLOSE_CONTACT_MODAL: state => state.isOpen = false,
    },
}

export default contactModal