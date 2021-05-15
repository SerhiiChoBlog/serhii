interface Post {
    title: string
    intro: string
    slug: string
    tags: {
        id: number
        name: string
        color: string
    }[]
    image_sm: string
    pretty_created_at: string
}

type Posts = Post[]

export default Posts