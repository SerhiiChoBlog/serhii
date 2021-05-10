import Posts from '@/interfaces/posts/Posts'
import Post from '@/interfaces/posts/Post'

export default interface PostsState {
    processingPosts: boolean
    postsError: string | null
    posts: Posts
    post: Post
    processingPost: boolean
}