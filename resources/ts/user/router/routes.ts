import { RouteRecordRaw } from 'vue-router'
import Profile from '@user/views/Profile.vue'
import NotFound from '@shared/components/NotFound.vue'

const routes: RouteRecordRaw[] = [
    { path: '/user/:slug?', name: 'profile', component: Profile },
    { path: '/:pathMatch(.*)', name: 'not-found', component: NotFound },
]

export default routes
