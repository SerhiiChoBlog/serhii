import { RouteRecordRaw } from 'vue-router'
import About from '@/views/About.vue'
import Posts from '@/views/posts/Posts.vue'
import Post from '@/views/posts/Post.vue'
import Projects from '@/views/projects/Projects.vue'
import Project from '@/views/projects/Project.vue'
import Page404 from '@/views/Page404.vue'

const routes: Array<RouteRecordRaw> = [
    { path: '/', component: About },
    { path: '/posts', component: Posts },
    { path: '/posts/:postId', component: Post },
    { path: '/projects', component: Projects },
    { path: '/projects/:projectName', component: Project },
    { path: '/draft/:postId', component: Post },
    { path: '/:catchAll(.*)', component: Page404 }
]

export default routes