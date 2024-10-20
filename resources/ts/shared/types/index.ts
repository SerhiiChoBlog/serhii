import type { Tag, User } from './models'

export type SocialName =
    | 'twitter'
    | 'x'
    | 'linkedin'
    | 'reddit'
    | 'telegram'
    | 'facebook'
    | 'clipboard'
export type Theme = 'light' | 'dark' | 'system'
export type FeedType = 'comment' | 'post-like' | 'badge' | 'comment-like'

export type Chapter = {
    title: string
    isActive: boolean
    tag: 'H2' | 'H3'
    slug: string
}

export type SavedChapter = {
    chapter: Chapter
    top: number
}

export type SocialLink = {
    href: string | null
    title: SocialName
    tip: string
    action?: () => void
}

export type SearchSuggestion = {
    title: string
    url: string
    selected: boolean
    slug: string
    image_xs: string
    tags: string[]
    keywords: string[]
}

export type Search = {
    query: string
    posts: SearchSuggestion[]
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

export type Goal = {
    title: string
    goal: string
    min: number
    max: number
    daysLeft: number
}

export interface EditPostFormElements extends HTMLFormControlsCollection {
    title: HTMLInputElement
    intro: HTMLInputElement
    image: HTMLInputElement
    'is-published': HTMLInputElement
    'tags[]': HTMLInputElement[]
}

export interface EditSeriesFormElements extends HTMLFormControlsCollection {
    title: HTMLInputElement
    intro: HTMLInputElement
    color_from: HTMLInputElement
    color_to: HTMLInputElement
    image: HTMLInputElement
    'posts[]': HTMLInputElement[]
}

export interface CreateBookFormElements extends HTMLFormControlsCollection {
    title: HTMLInputElement
    image: HTMLInputElement
    book_author_id: HTMLInputElement
    rate: HTMLInputElement
    read_at: HTMLInputElement
}

export type SubscriptionForm = {
    loading: boolean
    email: string
}

export type SubscriptionTagsModal = {
    showModal: boolean
    loading: boolean
    items: Tag[]
}

export type SubscriptionDemandResponse = {
    message: string
    success: boolean
}

export type FirebaseSignUpRequest = {
    token: string
    email: string
    name: string
    photo_url: string | null
    sign_in_method: User['sign_in_method']
}

export type Testimonial = {
    image_uri: string
    name: string
    role: string
    content: string
    short?: string | null
    link?: string | null
}

export type WorkProject = {
    image_uri: string
    title: string
    subtitle: string
    content: string
    link: string
    technologies: string[]
}
