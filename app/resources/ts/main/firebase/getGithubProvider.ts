import { GithubAuthProvider } from 'firebase/auth'

export function getGithubProvider(): GithubAuthProvider {
    const provider = new GithubAuthProvider()

    provider.addScope('read:user')
    provider.addScope('user:email')

    return provider
}
