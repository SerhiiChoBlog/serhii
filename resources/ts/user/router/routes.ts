import { RouteRecordRaw } from 'vue-router'
import Profile from '@user/views/Profile/Profile.vue'

const routes: RouteRecordRaw[] = [
    { path: '/user/profile', name: 'profile', component: Profile },
]

export default routes
