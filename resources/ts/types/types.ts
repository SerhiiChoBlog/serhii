export interface Chapter {
    title: string
    isActive: boolean
}

export interface SavedChapter {
    chapter: Chapter
    top: number
}

export interface SearchSuggestion {
    title: string
    url: string
    slug?: string
}

export interface Search {
    query: string
    posts: SearchSuggestion[]
    projects: SearchSuggestion[]
    loading: boolean
    history: SearchSuggestion[]
}

export interface SearchServerResponse {
    posts: SearchSuggestion[]
    projects: SearchSuggestion[]
}
