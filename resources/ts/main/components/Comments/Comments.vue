<script setup lang="ts">
import type { Comment as CommentType } from '@shared/types/models'
import axios from 'axios'
import { onMounted, ref } from 'vue'
import Spinner from '@/components/Spinner.vue'
import Comment from './Comment.vue'
import CommentForm from './CommentForm.vue'

type Props = {
    postSlug: string
}

const { postSlug } = defineProps<Props>()

const comments = ref<CommentType[]>([])
const loading = ref<boolean>(false)

onMounted(() => fetchComments())

function fetchComments(): void {
    loading.value = true

    axios.get<CommentType[]>(`/api/comments/${postSlug}`)
        .then(resp => comments.value = resp.data)
        .catch(err => console.error(err))
        .finally(() => loading.value = false)
}
</script>

<template>
    <div v-if="loading" class="flex gap-6 items-center justify-center">
        <spinner class="mx-0" />
        <h2 class="text-2xl">Loading comments...</h2>
    </div>

    <div v-else-if="comments.length > 0" class="flex flex-col gap-4">
        <comment
            v-for="comment in comments"
            :key="comment.id"
        />
    </div>

    <h2 class="text-2xl" v-else>Be the first to leave a comment</h2>

    <comment-form />
</template>
