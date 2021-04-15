import { useStore } from 'vuex'
import { computed } from 'vue'

export default () => {
    const store = useStore()
    const isOpen = computed(() => store.state.isOpen)

    function openContactModal(): void {
        store.commit('OPEN_CONTACT_MODAL')
    }

    function closeContactModal(): void {
        store.commit('CLOSE_CONTACT_MODAL')
    }

    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeContactModal()
        }
    })

    return { isOpen, openContactModal, closeContactModal }
}