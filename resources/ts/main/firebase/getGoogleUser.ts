import type { FirebaseSignUpRequest } from '@shared/types'
import firebase from '@/firebase'
import showToast from '@shared/modules/showToast'

export default (onSuccess: (params: FirebaseSignUpRequest) => void, onError: (err: any) => void) => {
    const provider = new firebase.auth.GoogleAuthProvider()

    provider.addScope('email')
    provider.addScope('profile')

    firebase.auth()
        .signInWithPopup(provider)
        .then(resp => handleResponse(resp))
        .catch(err => onError(err))

    async function handleResponse(resp: firebase.auth.UserCredential): Promise<void> {
        const user = resp.user || null

        if (!user || !user.email || !user.displayName) {
            showToast({
                text: 'Google service error',
                success: false,
            })
            return
        }

        const tokenField = document.querySelector('meta[name="csrf-token"]')
        const token = tokenField ? tokenField.getAttribute('content') : null

        if (!token) {
            showToast({
                text: 'CSRF token not found',
                success: false,
            })
            return
        }

        const params: FirebaseSignUpRequest = {
            token,
            sign_in_method: 'google',
            email: user.email,
            name: user.displayName,
            photo_url: user.photoURL,
        }

        onSuccess(params)
    }
}
