import { createRouter, createWebHashHistory } from 'vue-router'
import store from '@/store'
import routes from '@/router/routes'

const router = createRouter({
    linkActiveClass: 'is-active',
    history: createWebHashHistory(),
    routes,
})

router.beforeEach(() => {
    store.dispatch('closeNavMenu')
})

export default router
