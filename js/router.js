import Vue from 'vue'
import VueRouter from 'vue-router'
import Cabinet from './views/Cabinet'
import Projects from './views/Projects/Projects'
import Project from './views/Projects/Project'
import AddProject from './views/Projects/AddProject'
import Login from './views/auth/Login'

Vue.use(VueRouter);

export const router = new VueRouter({
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
            path: '/add-project',
            component: AddProject,
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
