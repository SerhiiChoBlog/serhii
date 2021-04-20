import { Module } from 'vuex'
import NavbarState from '@/store/interfaces/NavbarState'
import RootState from '@/store/interfaces/RootState'

const navbar: Module<NavbarState, RootState> = {
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