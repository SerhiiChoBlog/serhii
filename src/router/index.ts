import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store'
import routes from '@/router/routes'
import updatePageViews from '@/modules/updatePageViews'

const router = createRouter({
    linkActiveClass: 'is-active',
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

router.beforeEach((to, from) => {
    store.dispatch('closeNavMenu')
})

router.afterEach((to, from) => {
    updatePageViews(to)
})

export default router
