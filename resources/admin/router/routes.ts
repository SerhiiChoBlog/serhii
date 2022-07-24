import { RouteRecordRaw } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Posts from '../views/Posts/Posts.vue'
import CreatePost from '../views/Posts/CreatePost.vue'
import EditPost from '../views/Posts/EditPost.vue'

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
        component: CreatePost,
    },
    {
        path: '/admin/posts/{id}/edit',
        name: 'edit-post',
        component: EditPost,
    },
]

export default routes
