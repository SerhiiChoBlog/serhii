<script setup lang="ts">
import type { Keyword, Post } from '@shared/types/models'
import { ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import FormInput from '@admin/components/Form/FormInput.vue'

type Props = {
    post: Post
}

type Emits = {
    (e: 'changed'): void
}

const emit = defineEmits<Emits>()

const props = defineProps<Props>()
const suggestions = ref<Keyword[]>([])
const searchQuery = ref('')

function fetchSuggestions(): void {
    if (searchQuery.value === '') {
        suggestions.value = []
        return
    }

    axios.get<Keyword[]>(`/admin/ajax/keywords/search/${searchQuery.value}`)
        .then(resp => suggestions.value = resp.data)
        .catch(handleError)
}

function addKeyword(): void {
    if (searchQuery.value === '') {
        suggestions.value = []
        return
    }

    axios.post(`/admin/ajax/keywords`, {
        name: searchQuery.value,
        post_id: props.post.id
    })
        .then(resp => {
            suggestions.value = []
            searchQuery.value = ''
            emit('changed')
        })
        .catch(handleError)
}

function inputChanged(val: string): void {
    searchQuery.value = val
    fetchSuggestions()
}

function deleteKeyword(keyword: Keyword): void {
    if (!confirm(`Are you sure you want to delete the keyword "${keyword.name}"?`)) {
        return
    }

    axios.delete('/admin/ajax/keywords', {
        data: {
            keyword_id: keyword.id,
            post_id: props.post.id
        }
    })
        .then(resp => emit('changed'))
        .catch(handleError)
}
</script>

<template>
    <div class="relative">
        <FormInput
            type="text"
            id="post-keywords"
            name="post-keywords"
            placeholder="Start typing to add a keyword..."
            @changed="inputChanged"
            @keydown.enter.prevent="addKeyword"
            :value="searchQuery"
        >
            Keywords:
        </FormInput>

        <!-- Suggestions dropdown -->
        <ul class="bg-white shadow-md mt-2 rounded-md overflow-hidden absolute inset-x-0">
            <li
                v-for="keyword in suggestions"
                :key="keyword.name"
                class="border-b border-border px-3 py-1 hover:bg-page-second"
            >
                {{ keyword.name }}
            </li>
        </ul>

        <div class="mt-2 flex flex-wrap gap-1">
            <div
                v-for="keyword in props.post.keywords"
                :key="keyword.name"
                class="inline-block bg-main text-white px-2 py-0.5 rounded-md"
            >
                <span>{{ keyword.name }}</span>

                <button
                    @click="deleteKeyword(keyword)"
                    type="button"
                    class="ml-2 hover:scale-110 hover:text-green-200"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</template>
