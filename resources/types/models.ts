export type Tag = {
    id: number
    title: string
    description: string
    name: string
    color: string
    posts_count?: number
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
    pageViews?: PageView[]
    socialShares?: SocialShare[]
    social?: string[][]
    tags?: Tag[]
    social_shares_count?: number
    page_views_count?: number
    read_time: number
    pretty_created_at: string
    created_at: string
    updated_at: string
    published_at: string
}

export type PageView = {
    id: number
    visitor_id: number
    slug: string
    amount: number | null
    created_at: string
    updated_at: string
    date: string | null
}

export type Visitor = {
    id: number
    ip: string
    country: string
    city: string
    code: string
    page_views_count: number | null
    pageViews?: PageView[]
    socialShares?: SocialShare[]
}

export type SocialShare = {
    id: number
    post_id: number
    visitor_id: number
    social: string
    post?: Post
    visitor?: Visitor
    created_at: string
}

export type Hit = {
    id: number
    amount: number
    updated_at: number
    created_at: number
}

export type Referrer = {
    id: number
    name: string
    site: string
    hash: string
    hits: number
    pretty_updated_at: string
    created_at: string
    updated_at: string
}
