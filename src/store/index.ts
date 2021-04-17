import { createStore } from 'vuex'
import contactModal from '@/store/modules/contactModal'
import navbar from '@/store/modules/navbar'

export default createStore({
    strict: true,

    modules: {
        contactModal,
        navbar,
    },
})
