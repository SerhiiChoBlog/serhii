import { Module } from "vuex"

interface NavbarState {
    menuIsOpen: boolean,
}

const navbar: Module<NavbarState, {}> = {
    state: {
        menuIsOpen: false,
    },

    mutations: {
        OPEN_NAV_MENU: state => state.menuIsOpen = true,
        CLOSE_NAV_MENU: state => state.menuIsOpen = false,
    },
}

export default navbar