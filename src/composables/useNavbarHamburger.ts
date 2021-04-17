import { computed } from "@vue/runtime-core"
import { useStore } from "vuex"

export default () => {
    const store = useStore()
    const menuIsOpen = computed(() => store.state.navbar.menuIsOpen)

    function toggleMobileNavbar() {
        menuIsOpen.value
            ? store.dispatch('closeNavMenu')
            : store.dispatch('openNavMenu')
    }

    return { menuIsOpen, toggleMobileNavbar }
}