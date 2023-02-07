import firebase from '@/firebase'
import showToast from '@shared/modules/showToast'

export default (onSuccess: (accessToken: string) => void, onError: (err: any) => void) => {
    const provider = new firebase.auth.GoogleAuthProvider()

    provider.addScope('email')
    provider.addScope('profile')

    firebase.auth()
        .signInWithPopup(provider)
        .then(resp => handleResponse(resp))
        .catch(err => onError(err))

    async function handleResponse(resp: firebase.auth.UserCredential): Promise<void> {
        const user = resp.user || null

        if (!user) {
            showToast({
                text: 'Google service error',
                success: false,
            })
            return
        }

        const providerData = user.providerData[0] || null
        const credential = resp.credential || null

        if (!providerData || !credential) {
            showToast({
                text: 'Google service error',
                success: false,
            })
            return
        }

        // @ts-ignore
        const accessToken = credential.accessToken

        onSuccess(accessToken)
    }
}
