export interface Chapter {
    title: string
    isActive: boolean
}

export interface SavedChapter {
    chapter: Chapter
    top: number
}
