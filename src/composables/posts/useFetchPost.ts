import { useRoute } from 'vue-router'
import { onMounted, computed } from 'vue'
import Post from '@/interfaces/posts/Post'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const { params: { postId } } = useRoute()

    const post = computed<Post>(() => store.state.posts.post)
    const postLoading = computed<boolean>(() => store.state.posts.processingPosts)
    const postError = computed<string | null>(() => store.state.posts.postError)

    onMounted(() => {
        store.dispatch('fetchPost', postId)
    })

    return { post, postLoading, postError }
}