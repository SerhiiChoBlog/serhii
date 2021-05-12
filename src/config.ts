// export const host = 'http://localhost:8000/'
export const host = 'https://api.serhii.io/'

export const isProduction = window.location.hostname === 'serhii.io'

export function getProjectsUrl(): string {
    return `${host}api/projects`
}

export function getProjectContentUrl(projectSlug: string): string {
    return `https://raw.githubusercontent.com/SerhiiCho/${projectSlug}/master/README.md`
}

export function getUpdatePageViewsUrl(): string {
    return `${host}api/page-view/update`
}

export function getPostsUrl(): string {
    return `${host}api/posts`
}

export function getPostUrl(postId: number): string {
    return `${host}api/posts/${postId}`
}