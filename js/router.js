import Vue from 'vue'
import VueRouter from 'vue-router'
import Projects from './views/projects/Projects'
import Project from './views/projects/Project'
import About from './views/About'

Vue.use(VueRouter)

const router = new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 }
    },
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/',
            component: Projects,
        },
        {
            path: '/about',
            component: About,
        },
        {
            path: '/project/:id',
            component: Project,
            props: true,
            name: 'single',
        },
        {
            path: '*',
            component: Projects,
        },
    ],
})

router.afterEach((to, from) => Event.$emit('new-view'))

export default router