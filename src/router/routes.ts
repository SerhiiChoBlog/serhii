import { RouteRecordRaw } from 'vue-router'
import About from '@/views/About.vue'
import Blog from '@/views/Blog.vue'
import Projects from '@/views/projects/Projects.vue'
import Project from '@/views/projects/Project.vue'
import Page404 from '@/views/Page404.vue'
// import Login from '@/views/Login.vue'
// import Dashboard from '@/views/Dashboard.vue'
// import { authGuard } from '@/router/guards'

const routes: Array<RouteRecordRaw> = [
    { path: '/', component: About },
    { path: '/blog', component: Blog },
    { path: '/projects', component: Projects },
    { path: '/projects/:projectName', component: Project },
    // { path: '/login', component: Login },
    // { path: '/dashboard', component: Dashboard, beforeEnter: authGuard },
    { path: '/:catchAll(.*)', component: Page404 }
]

export default routes