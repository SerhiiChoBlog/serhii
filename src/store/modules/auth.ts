import { LoginCredentials } from '@/interfaces/auth/LoginCredentials'
import { Module } from 'vuex'
import firebase from '@/firebase'
import router from '@/router'

interface AuthState {
    processingAuth: boolean
    errorAuth: string | null
    isAuth: boolean
}

const auth: Module<AuthState, {}> = {
    state: {
        processingAuth: false,
        errorAuth: null,
        isAuth: false,
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
        SET_IS_AUTH(state, payload: boolean): void {
            state.isAuth = payload
        },
    },

    actions: {
        changeAuthState({ commit }, payload): void {
            commit('SET_IS_AUTH', payload)
        },
        clearAuthError({ commit }) {
            commit('CLEAR_AUTH_ERROR')
        },
        login({ commit }, { email, password }: LoginCredentials): void {
            commit('SET_AUTH_PROCESSING', true)
            commit('CLEAR_AUTH_ERROR')

            firebase.auth()
                .signInWithEmailAndPassword(email, password)
                .then(resp => {
                    if (resp.user)
                        router.push('/dashboard')
                })
                .catch(err => commit('SET_AUTH_ERROR', err.message))
                .finally(() => commit('SET_AUTH_PROCESSING', false))
        },
    },
}

export default auth