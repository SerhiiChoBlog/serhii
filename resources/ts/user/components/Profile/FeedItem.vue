<script setup lang="ts">
import type { Feed } from '@shared/types/models'
import { computed } from 'vue'

type Props = {
    feed: Feed
}

const { feed } = defineProps<Props>()

const content = computed(() => {
    switch (feed.type) {
        case 'post-like':
            return feed.post!.intro
        case 'comment':
        case 'comment-like':
            return feed.comment!.comment
        case 'badge':
            return `User receives a badge: ${feed.badge!.name}`
    }
})
</script>

<template>
    <div class="grid grid-cols-[60px_auto] gap-5 bg-page-second rounded-lg px-5 py-3 space-y-1.5">
        <div v-if="feed.image" class="flex items-center">
            <a :href="feed.url ? feed.url : 'javascript:'">
                <img
                    :src="`/${feed.image}`"
                    class="w-full rounded-md h-[60px] object-contain object-center"
                    alt="Feed image"
                    width="60"
                    height="60"
                />
            </a>
        </div>

        <div>
            <span class="opacity-70">{{ feed.user.name }} likes this</span>
            <h2 class="text-lg opacity-80">{{ content }}</h2>
        </div>
    </div>
</template>
