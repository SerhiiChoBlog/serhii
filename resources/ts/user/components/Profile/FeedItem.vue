<script setup lang="ts">
import type { Feed } from '@shared/types/models'

type Props = {
    title: string
    content: string
    image: string
    url?: string
    feed: Feed
}

const { title, content, image, url, feed } = defineProps<Props>()
</script>

<template>
    <div class="grid grid-cols-[60px_auto] gap-5 bg-page-second rounded-lg px-5 py-3 space-y-1.5">
        <div v-if="image" class="flex items-center">
            <a :href="url ? url : 'javascript:'">
                <img
                    :src="image"
                    class="w-full rounded-md h-[60px] object-contain object-center"
                    alt="Feed image"
                    width="60"
                    height="60"
                />
            </a>
        </div>

        <div>
            <span class="opacity-70">{{ feed.user.name }} {{ title }} {{ feed.pretty_date }}</span>
            <h2 class="text-lg opacity-80">{{ content }}</h2>
        </div>
    </div>
</template>
