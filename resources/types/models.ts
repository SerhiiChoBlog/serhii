export type Tag = {
    id: number
    title: string
    description: string
    name: string
    color: string
    posts_count: number | null
}

export type PostContentImage = {
    id: number
    post_id: number
    uri: string
    path: string
    post: Post
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
    images?: PostContentImage[]
    // socialShares?: Collection
    // pageViews?: Collection
    // social?: array<int, array<int, string>> | null
    tags?: Tag[]
    social_shares_count: number | null
    page_views_count: number | null
    read_time: number
    pretty_created_at: string
    created_at: string
    updated_at: string
    published_at: string
}
