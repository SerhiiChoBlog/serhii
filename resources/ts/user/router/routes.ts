import { RouteRecordRaw } from 'vue-router'
import Profile from '@user/views/Profile.vue'

const routes: RouteRecordRaw[] = [
    { path: '/user', name: 'profile', component: Profile },
]

export default routes
