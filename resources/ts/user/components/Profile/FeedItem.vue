<script setup lang="ts">
import type { Feed } from '@shared/types/models'

type Props = {
    feed: Feed
}

const { feed } = defineProps<Props>()
</script>

<template>
    <li class="grid grid-cols-[60px_auto] gap-5 bg-page-second rounded-lg px-5 py-3 space-y-1.5">
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
            <span class="opacity-70">{{ feed.title }} {{ feed.pretty_date }}</span>
            <h2 class="text-lg opacity-80">{{ feed.content }}</h2>
        </div>
    </li>
</template>
