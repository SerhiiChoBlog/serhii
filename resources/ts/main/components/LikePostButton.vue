<script setup lang="ts">
import type { Post } from '@shared/types/models'
import type { GetPostLikesResponse } from '@shared/types/response'
import dispatchEvent from '@shared/modules/dispatchEvent'
import { events } from '@shared/appConfig'
import { onMounted, ref } from 'vue'
import axios from 'axios'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()

onMounted(() => fetchIsLiked())

const btn = ref<HTMLButtonElement | null>(null)
const isLiked = ref<boolean>(false)
const likes = ref<number>(0)
const loading = ref<boolean>(false)

function toggleLike(): void {
    if (!Auth) {
        dispatchEvent(events.openLoginModal)
        return
    }

    loading.value = true

    const params = {
        post_id: post.id,
        secret: Auth.secret
    }

    axios.post<GetPostLikesResponse>(`/api/post-likes`, params)
        .then(res => {
            isLiked.value = res.data.liked
            likes.value = res.data.likes
        })
        .catch(err => console.error(err))
        .finally(() => loading.value = false)
}

function fetchIsLiked(): void {
    loading.value = true

    const params = {
        post_id: post.id,
        secret: Auth ? Auth.secret : null
    }

    axios.get<GetPostLikesResponse>('/api/post-likes/is-liked', { params })
        .then(res => {
            isLiked.value = res.data.liked
            likes.value = res.data.likes
        })
        .catch(err => console.error(err))
        .finally(() => loading.value = false)
}
</script>

<template>
    <button
        type="button"
        @click="toggleLike"
        ref="btn"
        :aria-label="`${isLiked ? 'Unlike' : 'Like'} this post`"
        class="print:hidden fixed bottom-2 right-2 md:bottom-6 md:right-6 z-30 p-2 rounded-full bg-page border-2 transition-all duration-300 hover:shadow-[0_0_20px_red,inset_0_0_10px_red] hover:text-red-400 hover:animate-pulse"
        :class="{
            'opacity-30 pointer-events-none': loading,
            'opacity-90': !loading,
            'border-red-500 dark:border-red-400 shadow-red-400': isLiked,
            'border-gray-700 dark:border-gray-400 border-gray-700 dark:border-gray-200': !isLiked,
        }"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            :fill="isLiked ? 'currentColor' : 'none'"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-7 h-7"
            :class="{
                'text-red-500 dark:text-red-400': isLiked,
                'text-gray-700 dark:text-gray-400': !isLiked,
            }"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
            />
        </svg>


        <span
            v-if="likes > 0"
            class="absolute -top-2 right-[34px] text-[.9rem] font-bold bg-page px-1.5 rounded-full border"
            :class="{
                'text-red-500 dark:text-red-500 border-red-500': isLiked,
                'text-gray-700 dark:text-gray-400 border-gray-700 dark:border-gray-400': !isLiked,
            }"
        >
            {{ likes }}
        </span>
    </button>
</template>
