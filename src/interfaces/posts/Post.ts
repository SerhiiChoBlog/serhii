export default interface Post {
    title: string
    intro: string
    content: string
    tags: {
        id: number
        post_id: number
        name: string
    }[]
    image_url: string
    read_time: number | null
    created_at: string
}