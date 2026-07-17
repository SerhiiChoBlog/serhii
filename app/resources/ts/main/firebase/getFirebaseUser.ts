import type { FirebaseSignUpRequest } from '@shared/types'
import type { User } from '@shared/types/models'
import showToast from '@shared/modules/showToast'
import { AuthProvider, signInWithPopup } from 'firebase/auth'
import { auth } from '@/firebase'

export async function getFirebaseUser(
    onSuccess: (params: FirebaseSignUpRequest) => void,
    onError: (err: any) => void,
    provider: AuthProvider,
    serviceName: User['sign_in_method'],
) {
    try {
        const resp = await signInWithPopup(auth, provider)
        const user = resp.user || null

        if (!user || !user.email) {
            const text = `${serviceName} service error`
            showToast({ text, success: false })
            return
        }

        if (!user.displayName) {
            // @ts-ignore
            user.displayName = user.email.split('@')[0]
        }

        const tokenField = document.querySelector('meta[name="csrf-token"]')
        const token = tokenField ? tokenField.getAttribute('content') : null

        if (!token) {
            const text = 'CSRF token error. You are probably doing something wrong.'
            showToast({ text, success: false })
            return
        }

        const params: FirebaseSignUpRequest = {
            token,
            sign_in_method: serviceName,
            email: user.email,
            name: user.displayName,
            photo_url: user.photoURL,
        }

        onSuccess(params)
    } catch (err) {
        onError(err)
    }
}
