import Posts from '@/interfaces/posts/Posts'
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const posts = computed<Posts>(() => store.state.posts.posts)
    const processingPosts = computed<boolean>(() => store.state.posts.processingPosts)
    const postsError = computed<string | null>(() => store.state.posts.postsError)

    onMounted(() => {
        if (posts.value.length === 0) {
            store.dispatch('fetchPosts')
        }
    })

    return { posts, processingPosts, postsError }
}