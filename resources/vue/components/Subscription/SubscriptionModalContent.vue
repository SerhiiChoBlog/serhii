<script setup lang="ts">
import type { SubscriptionTagsModal } from '@/../types'
import Spinner from '@/components/Spinner.vue'
import { ref } from 'vue'
import { Tag } from '@/../types/models'

type Props = {
    tags: SubscriptionTagsModal
}

const props = defineProps<Props>()
const subjects = ref<Tag[]>([])
</script>

<template>
    <div>
        <div class="mb-7 text-center">
            <h2 class="text-2xl">Choose subjects to subscribe</h2>
            <p class="text-xl">You will be subscribed to
                <b class="text-green-700 font-sans">{{ subjects.length === 0 ? 'all' : subjects.length }}</b>
                subjects
            </p>
        </div>

        <spinner v-if="props.tags.loading" />

        <ul v-else class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <li
                v-for="tag in props.tags.items"
                :key="tag.id"
                class="flex items-center gap-7 border border-border rounded-lg py-2 px-3"
            >
                <div>
                    <img
                        :src="`/storage/tags/${tag.name}.webp`"
                        :alt="`The logo of ${tag.name}`"
                        width="200"
                        height="200"
                        class="w-[50px] rounded-md drop-shadow-md"
                    />
                </div>

                <div>
                    <h3 class="font-semibold font-sans text-lg">{{ tag.title }}</h3>
                    <p class="text-font-second text-md">{{ tag.description }}</p>
                </div>
            </li>
        </ul>
    </div>
</template>
