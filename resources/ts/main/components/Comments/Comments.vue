<script setup lang="ts">
import type { Comment as CommentType } from '@shared/types/models'
import axios from 'axios'
import { onMounted, ref } from 'vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import Comment from '@/components/Comments/Comment.vue'
import CommentForm from '@/components/Comments/CommentForm.vue'
import CommentIcon from '@shared/components/Icons/CommentIcon.vue'

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
    <div class="mb-7 max-w-[650px] mx-auto">
        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">
            <comment-icon class="w-8 h-8 inline-block" />
            Discussion ({{ comments.length }})
        </h2>

        <comment-form />

        <div v-if="loading" class="flex gap-6 items-center justify-center">
            <spinner class="mx-0" />
            <h2 class="text-2xl">Loading comments...</h2>
        </div>

        <div v-else-if="comments.length > 0" class="flex flex-col gap-4">
            <comment
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
            />
        </div>

        <h2 v-else class="text-xl text-center text-font-second mb-10">
            🙏 Be the first to leave a comment
        </h2>
    </div>
</template>
