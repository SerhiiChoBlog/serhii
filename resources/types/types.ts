export type Chapter = {
    title: string
    isActive: boolean
}

export type SavedChapter = {
    chapter: Chapter
    top: number
}

export type SearchSuggestion = {
    title: string
    url: string
    selected: boolean
    slug?: string
    tags?: { name: string, color: string }[]
    image_sm?: string
}

export type Search = {
    query: string
    posts: SearchSuggestion[]
    history: SearchSuggestion[]
    loading: boolean
    suggestionsIndex: number
}

export type UserSidebarLink = {
    routeName: string
    title: string
    icon: string
}

export type Section = {
    title: string
    value: string
}

export interface EditPostFormElements extends HTMLFormControlsCollection {
    title: HTMLInputElement
    intro: HTMLInputElement
    image: HTMLInputElement
    'tags[]': HTMLInputElement[]
    'is-published': HTMLInputElement
}
