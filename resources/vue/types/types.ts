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
    selected: boolean
    slug?: string
    tags?: { name: string, color: string }[]
    image_sm?: string
}

export interface Search {
    query: string
    posts: SearchSuggestion[]
    history: SearchSuggestion[]
    loading: boolean
    suggestionsIndex: number
}
