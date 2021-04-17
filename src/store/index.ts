import { createStore } from 'vuex'
import contactModal from '@/store/modules/contactModal'

export default createStore({
    strict: true,

    modules: {
        contactModal,
    },
})
