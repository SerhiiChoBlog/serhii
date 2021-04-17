import { computed } from "@vue/runtime-core"
import { useStore } from "vuex"

export default () => {
    const store = useStore()
    const menuIsOpen = computed(() => store.state.navbar.menuIsOpen)

    function toggleMobileNavbar() {
        menuIsOpen.value
            ? store.commit('CLOSE_NAV_MENU')
            : store.commit('OPEN_NAV_MENU')
    }

    return { menuIsOpen, toggleMobileNavbar }
}