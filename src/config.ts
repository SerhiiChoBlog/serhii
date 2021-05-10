const host = 'http://localhost:8000/api'
// const host = 'https://api.serhii.io/api'

export const isProduction = window.location.hostname === 'serhii.io'

export function getProjectsUrl(): string {
    return `${host}/projects`
}

export function getProjectContentUrl(projectSlug: string): string {
    return `https://raw.githubusercontent.com/SerhiiCho/${projectSlug}/master/README.md`
}

export function getUpdatePageViewsUrl(): string {
    return `${host}/page-view/update`
}

export function getPostsUrl(): string {
    return `${host}/posts`
}

export function getPostUrl(postId: number): string {
    return `${host}/posts/${postId}`
}