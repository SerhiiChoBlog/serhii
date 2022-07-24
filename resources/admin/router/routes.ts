import { RouteRecordRaw } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Posts from '../views/Posts/Posts.vue'

const routes: RouteRecordRaw[] = [
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },
    {
        path: '/admin/posts',
        name: 'posts',
        component: Posts,
    },
    {
        path: '/admin/posts/create',
        name: 'create-post',
        component: Posts,
    },
]

export default routes
