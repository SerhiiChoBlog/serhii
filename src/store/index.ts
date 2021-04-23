import { createStore } from 'vuex'
import navbar from '@/store/modules/navbar'
import projects from '@/store/modules/projects'

export default createStore({
    strict: true,

    modules: {
        navbar,
        projects,
    },
})
