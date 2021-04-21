import { createStore } from 'vuex'
import contactModal from '@/store/modules/contactModal'
import navbar from '@/store/modules/navbar'
import projects from '@/store/modules/projects'

export default createStore({
    strict: true,

    modules: {
        contactModal,
        navbar,
        projects,
    },
})
