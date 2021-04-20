import { LoginCredentials } from "@/interfaces/auth/LoginCredentials"
import User from "@/interfaces/auth/User"
import { Module } from "vuex"
import firebase from '@/firebase'
import router from '@/router'

interface AuthState {
    processingAuth: boolean
    errorAuth: string | null
    user: User | null
}

const auth: Module<AuthState, {}> = {
    state: {
        processingAuth: false,
        errorAuth: null,
        user: null,
    },

    mutations: {
        SET_AUTH_PROCESSING(state, payload: boolean): void {
            state.processingAuth = payload
        },
        SET_AUTH_ERROR(state, payload: string): void {
            state.errorAuth = payload
        },
        CLEAR_AUTH_ERROR(state): void {
            state.errorAuth = null
        },
        SET_AUTH_USER(state, payload: User): void {
            state.user = payload
        },
    },

    actions: {
        clearAuthError({ commit }) {
            commit('CLEAR_AUTH_ERROR')
        },
        login({ commit }, { email, password }: LoginCredentials): void {
            commit('SET_AUTH_PROCESSING', true)

            firebase.auth()
                .signInWithEmailAndPassword(email, password)
                .then(resp => {
                    if (resp.user) {
                        commit('SET_AUTH_USER', { isAuth: true, userId: resp.user.uid })
                        router.push('/dashboard')
                    }
                })
                .catch(err => commit('SET_AUTH_ERROR', err.message))
                .finally(() => commit('SET_AUTH_PROCESSING', false))
        },
    },
}

export default auth