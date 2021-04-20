import { Module } from 'vuex'

interface NavbarState {
    menuIsOpen: boolean,
}

const navbar: Module<NavbarState, {}> = {
    state: {
        menuIsOpen: false,
    },

    mutations: {
        OPEN_NAV_MENU(state) {
            state.menuIsOpen = true
        },
        CLOSE_NAV_MENU(state) {
            state.menuIsOpen = false
        },
    },

    actions: {
        openNavMenu({ commit }) {
            commit('OPEN_NAV_MENU')
        },
        closeNavMenu({ commit }) {
            commit('CLOSE_NAV_MENU')
        },
    },
}

export default navbar