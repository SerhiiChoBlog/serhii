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
    const titleFontSize = computed<string>(() => pickCorrectFontSize(post.value.title.length))

    onMounted(() => {
        store.dispatch('fetchPost', postId)
    })

    return { post, postLoading, postError, titleFontSize }
}

function pickCorrectFontSize(fontLen: number): string {
    switch (true) {
        case (fontLen <= 10):
            return '4.8em'
        case (fontLen > 10 && fontLen < 20):
            return '3.8em'
        case (fontLen >= 20 && fontLen < 30):
            return '3.4em'
        case (fontLen >= 30 && fontLen < 40):
            return '2.8em'
        case (fontLen >= 40 && fontLen < 50):
            return '2.4em'
        case (fontLen >= 50 && fontLen < 60):
            return '2.2em'
    }

    return '2em'
}