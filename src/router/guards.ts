import { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'
import store from '@/store'

export function authGuard(to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext): void {
    store.state.auth.isAuth ? next() : next('/')
}