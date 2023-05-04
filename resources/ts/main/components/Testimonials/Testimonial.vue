<script setup lang="ts">
import type { Testimonial } from '@shared/types'

type Props = {
    testimonial: Testimonial
    showFull: boolean
}

type Emits = {
    (e: 'showFullContent'): void
}

const emit = defineEmits<Emits>()
const { testimonial, showFull } = defineProps<Props>()
</script>

<template>
    <figure class="relative flex flex-col rounded-lg p-6 shadow-lg bg-page">
        <figcaption class="flex items-center space-x-4">
            <img
                :src="testimonial.image_uri"
                :alt="testimonial.name"
                class="h-14 w-14 rounded-full shadow-md"
            />

            <div>
                <h3 class="font-bold text-xl text-gray-600">{{ testimonial.name }}</h3>
                <h3 class="text-gray-400">{{ testimonial.role }}</h3>
            </div>
        </figcaption>

        <blockquote class="mt-5 text-gray-500 leading-6 [&>p]:mb-5 [&>p:last-child]:mb-0">
            {{ !showFull && testimonial.short ? testimonial.short : testimonial.content }}

            <button
                v-if="showFull || !testimonial.short"
                type="button"
                @click="emit('showFullContent')"
                class="text-gray-500 hover:text-gray-600"
            >
                Show full
            </button>
        </blockquote>
    </figure>
</template>