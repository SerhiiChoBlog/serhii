export default interface GithubApiReposResponse {
    name: string
    html_url: string
    description: string
    language: string
    stars: number
    license: { key: string } | null
}