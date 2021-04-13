export function getProjectsUrl(): string {
    return 'https://api.github.com/users/SerhiiCho/repos'
}

export function getProjectContentUrl(projectSlug: string): string {
    return `https://raw.githubusercontent.com/SerhiiCho/${projectSlug}/master/README.md`
}

export function getProjectUrl(projectSlug: string): string {
    return `https://api.github.com/repos/SerhiiCho/${projectSlug}`
}