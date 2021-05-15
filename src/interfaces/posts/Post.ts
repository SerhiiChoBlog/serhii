export default interface Post {
    title: string
    intro: string
    content: string
    slug: string
    tags: {
        id: number
        name: string
        color: string
    }[]
    image_lg: string
    created_at: string
    pretty_created_at: string
}