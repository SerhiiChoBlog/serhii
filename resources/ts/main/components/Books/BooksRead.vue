<script setup lang="ts">
import type { Book } from '@shared/types/models'
import type { Pagination } from '@shared/types/response'
import handleServerError from '@shared/modules/handleServerError'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import Spinner from '@shared/components/Icons/Spinner.vue'

onMounted(() => fetchBooks())

const books = ref<Book[]>([])
const loading = ref<boolean>(false)
const nextPageUrl = ref<string | null>(null)

function fetchBooks() {
    loading.value = true

    axios.get<Pagination<Book[]>>('/api/about-me/books')
        .then(resp => {
            books.value = resp.data.data
            nextPageUrl.value = resp.data.next_page_url
        })
        .catch(handleServerError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <spinner v-if="loading" />

    <div v-else-if="books.length === 0" class="text-center">
        <h2 class="text-2xl">Sorry, I haven't added any books yet</h2>
    </div>

    <div v-else class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-4">
        <div
            v-for="book in books"
            :key="book.id"
            class="flex flex-col bg-white/50 dark:bg-black/20 rounded-md p-4"
        >
            <img
                :src="`/storage/books/${book.image}`"
                :alt="book.title"
                class="rounded-md shadow-lg"
            />

            <h3 class="text-lg leading-6 mt-4">
                {{ book.title }}
            </h3>

            <p class="flex justify-between text-sm mt-2 text-font-second">
                Author: {{ book.author.name }}
            </p>

            <span class="text-sm">
                Finish date {{ book.read_at }}
            </span>
        </div>
    </div>
</template>
