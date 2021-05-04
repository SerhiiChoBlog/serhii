const host = process.env.NODE_ENV === 'development'
    ? 'http://127.0.0.1:8000/api'
    : 'https://api.serhii.io/api'

console.log(host)

export function getProjectsUrl(): string {
    return `${host}/projects`
}

export function getProjectContentUrl(projectSlug: string): string {
    return `https://raw.githubusercontent.com/SerhiiCho/${projectSlug}/master/README.md`
}

export function getUpdatePageViewsUrl(): string {
    return `${host}/page-view/update`
}