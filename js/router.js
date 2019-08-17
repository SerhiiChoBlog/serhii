import Vue from 'vue'
import VueRouter from 'vue-router'
import Cabinet from './views/Cabinet'
import Projects from './views/Projects/Projects'
import Project from './views/Projects/Project'
import Login from './views/auth/Login'

Vue.use(VueRouter);

export const router = new VueRouter({
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
            path: '/project/:id',
            component: Project,
            props: true,
        },
        {
            path: '/login',
            component: Login,
        },
        {
            path: '/cabinet',
            component: Cabinet,
        },
        {
            path: '*',
            component: Projects,
        },
    ],
});
