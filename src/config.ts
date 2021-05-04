export const host = 'https://api.serhii.io/api'
export const isProduction = host.includes('serhii.io')

export function getProjectsUrl(): string {
    return `${host}/projects`
}

export function getProjectContentUrl(projectSlug: string): string {
    return `https://raw.githubusercontent.com/SerhiiCho/${projectSlug}/master/README.md`
}

export function getUpdatePageViewsUrl(): string {
    return `${host}/page-view/update`
}