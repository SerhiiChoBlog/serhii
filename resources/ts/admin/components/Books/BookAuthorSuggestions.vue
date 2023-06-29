<script setup lang="ts">
import type { BookAuthor } from '@shared/types/models'
import { ref } from 'vue'
import axios from 'axios'
import { debounce } from 'lodash'
import handleError from '@admin/modules/handleError'
import FormInput from '@admin/components/Form/FormInput.vue'

type Emits = {
    (e: 'changed'): void
}

const emit = defineEmits<Emits>()

const searchQuery = ref('')
const loading = ref<boolean>(false)
const accepted = ref<string | null>(null)
const suggestions = ref<BookAuthor[]>([])

function addAuthor(): void {
    if (searchQuery.value === '') {
        return
    }

    loading.value = true

    axios.post<BookAuthor[]>(`/admin/ajax/book-authors`, {
        name: searchQuery.value,
    })
        .then(resp => {
            searchQuery.value = ''
            emit('changed')
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}

const fetchSuggestions = debounce(() => {
    if (searchQuery.value === '') {
        suggestions.value = []
        return
    }

    loading.value = true

    axios.get<BookAuthor[]>(`/admin/ajax/book-authors/search/${searchQuery.value}`)
        .then(resp => {
            suggestions.value = resp.data || []
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}, 200)

function inputChanged(val: string): void {
    searchQuery.value = val
    fetchSuggestions()
}
</script>

<template>
    <div class="relative">
        <FormInput
            type="text"
            id="book-authors"
            name="book-authors"
            placeholder="Start typing to add an author..."
            @changed="inputChanged"
            @keydown.enter.prevent="addAuthor"
            :value="searchQuery"
        >
            <span v-if="accepted">Book author is {{ accepted }}</span>
            <span v-else>Enter a book's author</span>

            <i v-if="loading" class="fas fa-spinner fa-spin text-orange-600 ml-2"></i>
            <i v-else-if="accepted" class="fas fa-check text-green-600 ml-2"></i>
            <i v-else class="fas fa-arrow-left text-green-600 ml-2"></i>
        </FormInput>

        <div class="mt-2">
            <div v-if="suggestions.length === 0">
                <span>No suggestions yet</span>
            </div>
            <div v-else>
                <span>Suggestions:</span>

                <div class="inline-flex gap-1.5 ml-2">
                    <button
                        v-for="suggestion in suggestions"
                        :key="suggestion.id"
                        class="text-main hover:underline"
                        type="button"
                    >
                        {{ suggestion.name }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
