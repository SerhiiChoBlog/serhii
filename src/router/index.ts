import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store'
import routes from '@/router/routes'

const router = createRouter({
    linkActiveClass: 'is-active',
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

router.beforeEach(() => {
    store.dispatch('closeNavMenu')
})

export default router
