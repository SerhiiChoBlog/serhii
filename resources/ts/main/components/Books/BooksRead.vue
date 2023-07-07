<script setup lang="ts">
import type { Book } from '@shared/types/models'
import type { Pagination } from '@shared/types/response'
import handleServerError from '@shared/modules/handleServerError'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import Spinner from '@shared/components/Icons/Spinner.vue'
import BookRead from '@/components/Books/BookRead.vue'

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
        <book-read
            v-for="book in books"
            :key="book.id"
            :book="book"
        />
    </div>
</template>
