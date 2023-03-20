import type { SocialName } from '@shared/types/index'

export type Tag = {
    id: number
    title: string
    description: string
    name: string
    color: string
    posts_count?: number
    subscriptions?: Subscription[]
    pivot?: {
        post_id: number
        tag_id: number
        is_main: boolean
    }
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
    image_xs: string
    image_sm: string
    image_lg: string
    post_likes_count?: number
    images?: PostContentImage[]
    postViews?: PostView[]
    socialShares?: SocialShare[]
    keywords?: Keyword[]
    series?: Series[]
    tags?: Tag[]
    postLikes?: PostLike[]
    video?: Video | null
    social?: string[][]
    social_shares_count?: number
    post_views_count?: number
    comments_count?: number
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
    is_blocked: boolean
    is_robot: boolean
    post_views_count: number | null
    postViews?: PostView[]
    socialShares?: SocialShare[]
}

export type SocialShare = {
    id: number
    post_id: number
    visitor_id: number
    user_id: number | null
    social: SocialName
    post?: Post
    visitor?: Visitor
    created_at: string
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
    user_id: number | null
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
    sign_in_method: 'email' | 'google' | 'github'
    comments_count?: number
    email: string
    avatar: string
    email_verified_at: string
    created_at: string
    updated_at: string
    badges?: Badge[]
    ban?: Ban | null
    postLikes?: PostLike[]
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
    visitor_id: number|null
    comment_id: number | null
    comment: string
    comments?: Comment[]
    user?: User
    post?: Post
    visitor?: Visitor
    is_subscribed: boolean
    is_approved: boolean
    pretty_created_at: string
    created_at: string
}

export type Badge = {
    id: number
    name: 'verified' | 'commentator' | 'likable'
    description: string
    icon: string
    users?: User[]
}

export type Ban = {
    id: number
    user_id: number
    comment: string
    created_at: string
    updated_at: string
    user?: User
}

export type Keyword = {
    id: number
    name: string
    posts?: Post[]
}

export type Project = {
    id: number
    name: string
    title: string
    url: string
    description: string
    content: string
    has_homepage: boolean
    language: string
    stars: number
    created_at: string
    updated_at: string
}

export type Series = {
    id: number
    slug: string
    title: string
    intro: string
    color_from: string
    color_to: string
    description: string
    image_xs: string
    image_sm: string
    image_lg: string
    created_at: string
    updated_at: string
    posts?: Post[]
    pivot?: {
        post_id: number
        series_id: number
        part: number
    }
}

export type PostLike = {
    id: number
    post_id: number
    user_id: number
    created_at: string
    post?: Post
    user?: User
}
