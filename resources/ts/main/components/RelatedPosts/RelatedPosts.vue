<script setup lang="ts">
import PostItem from '@/components/RelatedPosts/PostItem.vue'
import type { Post } from '@shared/types/models'
import handleServerError from '@shared/modules/handleServerError'
import { onMounted, ref } from 'vue'
import axios from 'axios'

type Props = {
    postId: number
}

const { postId } = defineProps<Props>()
const posts = ref<Post[]>([])

onMounted(() => fetchPost())

function fetchPost(): void {
    axios.get<Post[]>(`/api/related-posts/${postId}`)
        .then(resp => posts.value = resp.data)
        .catch(err => handleServerError(err))
}
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
        <post-item
            v-for="post in posts"
            :key="post.id"
            :post="post"
        />
    </div>
</template>
