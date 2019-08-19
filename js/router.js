import Vue from 'vue'
import VueRouter from 'vue-router'
import Projects from './views/Projects/Projects'
import Project from './views/Projects/Project'

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
            name: 'single',
        },
        {
            path: '*',
            component: Projects,
        },
    ],
});
