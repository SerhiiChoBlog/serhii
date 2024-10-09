<script setup lang="ts">
import type { Book } from '@shared/types/models'
import BookRate from '@/components/Books/BookRate.vue'

defineProps<{ book: Book }>()
</script>

<template>
    <div
        class="flex group items-center justify-between bg-white/50 dark:bg-black/20 rounded-md p-2 relative"
    >
        <div
            class="absolute inset-2 opacity-0 group-hover:opacity-100 bg-white dark:bg-black flex flex-col items-center justify-center gap-2 p-2 rounded-md transition-opacity"
        >
            <h2 class="text-sm md:text-lg text-center leading-4 md:leading-6">
                {{ book.title }}
            </h2>

            <p
                class="flex justify-between text-xs md:text-sm text-font-second opacity-80"
            >
                {{ book.author!.name }}
            </p>

            <book-rate :rate="book.rate" />

            <small class="text-xs opacity-60">
                Finished {{ book.pretty_read_at }}
            </small>
        </div>

        <img
            :src="`/storage/books/${book.image}`"
            :alt="book.title"
            class="rounded-md shadow-lg"
        />
    </div>
</template>
