export const GITHUB_AUTH_TOKEN = 'token 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'

export function getProjectsUrl(): string {
    return 'https://api.github.com/users/SerhiiCho/repos'
}

export function getProjectContentUrl(projectSlug: string): string {
    return `https://raw.githubusercontent.com/SerhiiCho/${projectSlug}/master/README.md`
}