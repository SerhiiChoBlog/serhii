export type Tag = {
    id: number
    title: string
    description: string
    name: string
    color: string
}

export type Post = {
    id: number
    title: string
    slug: string
    intro: string | null
    content: string | null
    is_published: boolean
    image_sm: string
    image_lg: string
    // images: Collection
    // socialShares: Collection
    // pageViews: Collection
    tags: Tag[]
    // social: array<int, array<int, string>> | null
    social_shares_count: number | null
    page_views_count: number | null
    read_time: number
    pretty_created_at: string
    created_at: string
    updated_at: string
    published_at: string
}
