import { RouteRecordRaw } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'

const routes: RouteRecordRaw[] = [
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },
]

export default routes