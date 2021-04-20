import { createRouter, createWebHistory, NavigationGuardNext, RouteLocationNormalized, RouteRecordRaw } from 'vue-router'
import store from '@/store'
import About from '@/views/About.vue'
import Blog from '@/views/Blog.vue'
import Projects from '@/views/projects/Projects.vue'
import Project from '@/views/projects/Project.vue'
import Page404 from '@/views/Page404.vue'
import Login from '@/views/Login.vue'
import Dashboard from '@/views/Dashboard.vue'

const routes: Array<RouteRecordRaw> = [
    { path: '/', component: About },
    { path: '/blog', component: Blog },
    { path: '/projects', component: Projects },
    { path: '/projects/:projectName', component: Project },
    { path: '/login', component: Login },
    {
        path: '/dashboard',
        component: Dashboard,
        beforeEnter: authGuard,
    },
    { path: '/:catchAll(.*)', component: Page404 }
]

const router = createRouter({
    linkActiveClass: 'is-active',
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

router.beforeEach(() => {
    store.dispatch('closeNavMenu')
})

function authGuard(to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext): void {
    store.state.auth.isAuth ? next() : next('/')
}

export default router
