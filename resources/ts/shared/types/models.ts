export type Tag = {
    id: number
    title: string
    description: string
    name: string
    color: string
    posts_count?: number
    subscriptions?: Subscription[]
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
    video_id: number | null
    title: string
    slug: string
    intro: string | null
    content: string | null
    is_published: boolean
    image_sm: string
    image_lg: string
    images?: PostContentImage[]
    postViews?: PostView[]
    socialShares?: SocialShare[]
    tags?: Tag[]
    video?: Video | null
    social?: string[][]
    social_shares_count?: number
    post_views_count?: number
    read_time: number
    pretty_created_at: string
    created_at: string
    updated_at: string
    published_at: string
}

export type Video = {
    id: string
    post_id: number | null
    title: string
    description: string
    image: string
    url: string
    published_at: string
    created_at: string
    updated_at: string
}

export type PostView = {
    id: number
    visitor_id: number
    post_id: number
    post?: Post
    visitor?: Visitor
    created_at: string
    amount?: number
    date: string | null
}

export type Visitor = {
    id: number
    ip: string
    country: string
    city: string
    code: string
    post_views_count: number | null
    postViews?: PostView[]
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
    site: string
    hits: number
    pretty_updated_at: string
    created_at: string
    updated_at: string
}

export type PostPublication = {
    id: number
    user_id: number
    people_notified: number
    people_skipped: number
    post?: Post
    created_at: string
}

export type Subscription = {
    id: number
    email: string
    slug: string
    confirmed_at: string | null
    created_at: string
    updated_at: string
    tags?: Tag[]
}

export type User = {
    id: number
    slug: string
    roles?: Role[]
    name: string
    secret: string
    comments_count?: number
    email: string
    avatar: string
    email_verified_at: string
    created_at: string
    updated_at: string
}

export type Role = {
    id: number
    name: string
    users?: User[]
}

export type Comment = {
    id: number
    post_id: number
    user_id: number
    comment_id: number | null
    comment: string
    comments?: Comment[]
    user?: User
    is_subscribed: boolean
    is_approved: boolean
    pretty_created_at: string
    created_at: string
}
