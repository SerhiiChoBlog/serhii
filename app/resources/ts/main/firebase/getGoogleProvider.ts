import { GoogleAuthProvider } from 'firebase/auth'

export function getGoogleProvider(): GoogleAuthProvider {
    const provider = new GoogleAuthProvider()
    provider.addScope('email')
    provider.addScope('profile')

    return provider
}
