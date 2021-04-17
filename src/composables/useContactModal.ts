import { useStore } from 'vuex'
import { computed } from 'vue'

export default () => {
    const store = useStore()
    const isOpen = computed(() => store.state.contactModal.isOpen)

    function openContactModal(): void {
        store.dispatch('openContactModal')
    }

    function closeContactModal(): void {
        store.dispatch('closeContactModal')
    }

    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeContactModal()
        }
    })

    return { isOpen, openContactModal, closeContactModal }
}