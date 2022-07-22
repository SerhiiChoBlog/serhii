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
    selected: boolean
}

export interface Search {
    query: string
    posts: SearchSuggestion[]
    history: SearchSuggestion[]
    loading: boolean
    suggestionsIndex: number
}
