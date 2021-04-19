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
        SET_PROCESSING_AUTH({ processingAuth }, payload: boolean): void {
            processingAuth = payload
        },
        SET_ERROR_AUTH({ errorAuth }, payload: string): void {
            errorAuth = payload
        },
        CLEAR_ERROR_AUTH({ errorAuth }): void {
            errorAuth = null
        },
        SET_AUTH_USER({ user }, payload: User): void {
            user = payload
        },
    },

    actions: {
        login({ commit }, { email, password }: LoginCredentials): void {
            commit('SET_PROCESSING_AUTH', true)

            firebase.auth()
                .signInWithEmailAndPassword(email, password)
                .then(resp => {
                    if (resp.user) {
                        commit('SET_AUTH_USER', { isAuth: true, userId: resp.user.uid })
                        router.push('/dashboard')
                    }
                })
                .catch(err => commit('SET_ERROR_AUTH', err.message))
                .finally(() => commit('SET_PROCESSING_AUTH', false))
        },
    },
}

export default auth