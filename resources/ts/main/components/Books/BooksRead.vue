<script setup lang="ts">
import type { Book } from '@shared/types/models'
import type { Pagination } from '@shared/types/response'
import handleServerError from '@shared/modules/handleServerError'
import { onMounted, ref } from 'vue'
import axios from 'axios'

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
    here
</template>
