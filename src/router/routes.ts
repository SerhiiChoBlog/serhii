import { RouteRecordRaw } from 'vue-router'
import About from '@/views/About.vue'
import Blog from '@/views/Blog.vue'
import Projects from '@/views/projects/Projects.vue'
import Project from '@/views/projects/Project.vue'
import Page404 from '@/views/Page404.vue'

const routes: Array<RouteRecordRaw> = [
    { path: '/', component: About },
    { path: '/blog', component: Blog },
    { path: '/projects', component: Projects },
    { path: '/projects/:projectName', component: Project },
    { path: '/:catchAll(.*)', component: Page404 }
]

export default routes