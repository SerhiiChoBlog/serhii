export default interface Post {
    id: number
    title: string
    intro: string
    content: string
    tags: {
        id: number
        name: string
        color: string
    }[]
    image_lg: string
    pretty_created_at: string
}