import { RouteRecordRaw } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Posts from '../views/Posts/Posts.vue'
import CreatePost from '../views/Posts/CreatePost.vue'
import EditPost from '../views/Posts/EditPost.vue'
import Tags from '../views/Tags/Tags.vue'
import CreateTag from '../views/Tags/CreateTag.vue'
import EditTag from '../views/Tags/EditTag.vue'

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
        path: '/admin/posts/:id/edit',
        name: 'edit-post',
        component: EditPost,
    },
    {
        path: '/admin/tags',
        name: 'tags',
        component: Tags,
    },
    {
        path: '/admin/tags/create',
        name: 'create-tag',
        component: CreateTag,
    },
    {
        path: '/admin/tags/:id/edit',
        name: 'edit-tag',
        component: EditTag,
    },
]

export default routes
