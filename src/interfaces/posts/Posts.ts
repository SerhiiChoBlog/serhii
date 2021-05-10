interface Post {
    id: number
    title: string
    intro: string
    tags: string
    image_url: string
    read_time: number
    created_at: string
}

type Posts = Post[]

export default Posts