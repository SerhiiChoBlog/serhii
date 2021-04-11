import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import About from '@/views/About.vue'
import Blog from '@/views/Blog.vue'
import OpenSource from '@/views/openSource/OpenSource.vue'
import OpenSourceItem from '@/views/openSource/OpenSourceItem.vue'

const routes: Array<RouteRecordRaw> = [
    { path: '/', component: About },
    { path: '/blog', component: Blog },
    { path: '/open-source', component: OpenSource },
    { path: '/open-source/:name', component: OpenSourceItem },
    { path: '*', component: About },
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
