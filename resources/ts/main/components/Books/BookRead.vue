<script setup lang="ts">
import type { Book } from '@shared/types/models'
import BookRate from '@/components/Books/BookRate.vue'

type Props = {
    book: Book
}

const { book } = defineProps<Props>()
</script>

<template>
    <div class="flex justify-between flex-col bg-white/50 dark:bg-black/20 rounded-md p-4 gap-1.5">
        <div>
            <img
                :src="`/storage/books/${book.image}`"
                :alt="book.title"
                class="rounded-md shadow-lg"
            />

            <h3 class="text-lg leading-6 mt-4">
                {{ book.title }}
            </h3>

            <p class="flex justify-between text-sm mt-1 text-font-second">
                {{ book.author!.name }}
            </p>
        </div>

        <div>
            <book-rate :rate="book.rate" />

            <p class="text-sm opacity-60">
                Finished {{ book.pretty_read_at }}
            </p>
        </div>
    </div>
</template>
