import type { Tag } from './models'
import type { FunctionalComponent, HTMLAttributes, VNodeProps } from 'vue'

export type Component = FunctionalComponent<HTMLAttributes & VNodeProps, {}>

export type Badge = 'verified'

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
