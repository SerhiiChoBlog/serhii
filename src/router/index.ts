import {createRouter, createWebHistory, RouteRecordRaw} from 'vue-router'
import Home from '@/views/Home.vue'
import Blog from '@/views/Blog.vue'
import OpenSource from '@/views/OpenSource.vue'

const routes: Array<RouteRecordRaw> = [
    { path: '/', component: Home },
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

export default router
