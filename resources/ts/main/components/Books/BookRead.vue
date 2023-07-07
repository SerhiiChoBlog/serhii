<script setup lang="ts">
import type { Book } from '@shared/types/models'
import StarIcon from '@shared/components/Icons/StarIcon.vue'

type Props = {
    book: Book
}

const { book } = defineProps<Props>()
</script>

<template>
    <div class="flex justify-between flex-col bg-white/50 dark:bg-black/20 rounded-md p-4 gap-2">
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
            <div class="flex">
                <star-icon
                    v-for="rate in book.rate"
                    :key="rate"
                    class="w-5 h-5"
                    style="color: darkorange"
                    fill="darkorange"
                />

                <star-icon
                    v-for="rate in 5 - book.rate"
                    :key="rate"
                    class="w-5 h-5 opacity-60"
                    style="color: gray"
                    fill="gray"
                />
            </div>

            <span class="text-sm opacity-60">
                Finished {{ book.pretty_read_at }}
            </span>
        </div>
    </div>
</template>
