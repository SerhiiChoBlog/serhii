<script setup lang="ts">
import type { Post } from '@shared/types/models'
import type { GetPostLikesResponse } from '@shared/types/response'
import { onMounted, ref } from 'vue'
import axios from 'axios'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()

onMounted(() => {
    fetchIsLiked()

    if (btn) {
        showHideButton()

        window.addEventListener('scroll', e => showHideButton())
    }
})

const btn = ref<HTMLButtonElement | null>(null)
const isLiked = ref<boolean>(false)
const likes = ref<number>(0)
const loading = ref<boolean>(false)

function toggleLike(): void {
    if (!Auth) {
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
    if (!Auth) {
        return
    }

    loading.value = true

    const params = {
        post_id: post.id,
        secret: Auth.secret
    }

    axios.get<GetPostLikesResponse>('/api/post-likes/is-liked', { params })
        .then(res => {
            isLiked.value = res.data.liked
            likes.value = res.data.likes
        })
        .catch(err => console.error(err))
        .finally(() => loading.value = false)
}

function showHideButton(): void {
    if (!btn.value) {
        console.error('Go to top button not found')
        return
    }

    if (window.scrollY > 100) {
        btn.value.classList.remove('opacity-0')
        btn.value.classList.remove('pointer-events-none')
        btn.value.classList.add('opacity-90')
    } else {
        btn.value.classList.add('opacity-0')
        btn.value.classList.add('pointer-events-none')
        btn.value.classList.remove('opacity-90')
    }
}
</script>

<template>
    <button
        type="button"
        @click="toggleLike"
        class="print:hidden pointer-events-none opacity-0 fixed bottom-2 right-2 md:bottom-6 md:right-6 z-30 p-2 rounded-full bg-page border-2 border-gray-700 dark:border-gray-200 transition-all duration-300"
        ref="btn"
        aria-label=""
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-700 dark:text-gray-200">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
        </svg>

        <span
            v-if="likes > 0"
            class="absolute -top-2 right-1/2 mr-0.5 text-xs border border-gray-700 dark:border-gray-200 bg-page rounded-full px-1.5 py-0.5"
        >
            {{ likes }}
        </span>
    </button>
</template>
