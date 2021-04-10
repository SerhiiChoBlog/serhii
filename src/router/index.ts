import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import About from '@/views/About.vue'
import Blog from '@/views/Blog.vue'
import OpenSource from '@/views/OpenSource.vue'
import smoothLoader from 'smooth-loader'

const routes: Array<RouteRecordRaw> = [
    { path: '/', component: About },
    { path: '/blog', component: Blog },
    { path: '/open-source', component: OpenSource },
    // {
    //     path: '/blog',
    //     component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
    // }
]

const router = createRouter({
    linkActiveClass: 'is-active',
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

router.afterEach(guard => {
    window.setInterval(() => smoothLoader(), 0)
})

export default router
