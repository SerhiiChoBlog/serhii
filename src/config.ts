export function getProjectsUrl(): string {
    return 'https://api.serhii.io/api/projects'
}

export function getProjectContentUrl(projectSlug: string): string {
    return `https://raw.githubusercontent.com/SerhiiCho/${projectSlug}/master/README.md`
}