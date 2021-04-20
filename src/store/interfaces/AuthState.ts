export default interface AuthState {
    processingAuth: boolean
    errorAuth: string | null
    isAuth: boolean
    processingLogout: boolean
}