interface Post {
    id: number
    title: string
    intro: string
    tags: {
        id: number
        post_id: number
        name: string
    }[]
    image_url: string
    read_time: number
    updated_at: string
    created_at: string
}

type Posts = Post[]

export default Posts