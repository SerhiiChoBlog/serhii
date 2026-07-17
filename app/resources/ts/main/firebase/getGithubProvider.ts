import { GithubAuthProvider } from 'firebase/auth'

export default (): GithubAuthProvider => {
    const provider = new GithubAuthProvider()

    provider.addScope('read:user')
    provider.addScope('user:email')

    return provider
}
