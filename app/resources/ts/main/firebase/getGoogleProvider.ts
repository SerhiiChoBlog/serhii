import { GoogleAuthProvider } from 'firebase/auth'

export default (): GoogleAuthProvider => {
    const provider = new GoogleAuthProvider()
    provider.addScope('email')
    provider.addScope('profile')

    return provider
}
