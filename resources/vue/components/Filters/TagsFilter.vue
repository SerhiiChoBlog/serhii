<script setup lang="ts">
import type { Tag } from '../../../types/models'
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'
import { Listbox } from '@headlessui/vue'
import ListboxButton from '../Listbox/ListboxButton.vue'
import ListboxOptions from '../Listbox/ListboxOptions.vue'
import ListboxOption from '../Listbox/ListboxOption.vue'
import FilterTagLabel from './FilterTagLabel.vue'
import replaceQueryParam from '../../modules/replaceQueryParam'
import showEverythingTag from '../../modules/showEverythingTag'

type Props = {
    tagSlug: string
}

type Emits = {
    (e: 'tagIsLoaded', tag: Tag): void
}

const emit = defineEmits<Emits>()
const { tagSlug } = defineProps<Props>()

const tags = ref<Tag[]>([
    showEverythingTag,
])

const selectedTag = ref<Tag>(tags.value[0])

watch(selectedTag, () => {
    filterPosts(selectedTag.value)
})

onMounted(() => fetchTags())

function filterPosts(tag: Tag): void {
    if (tag.name === 'everything') {
        clearFilters()
        return
    }

    const query = replaceQueryParam('tag', tag.name)

    if (window.location.search != query) {
        window.location.href = `/posts${query}`
    }
}

function clearFilters(): void {
    window.location.href = `/posts`
}

function fetchTags(): void {
    axios.get<Tag[]>('/api/tags')
        .then(resp => {
            tags.value.push(...resp.data)

            if (tagSlug) {
                const match = resp.data.find(tag => tag.name === tagSlug.trim())

                if (match) {
                    selectedTag.value = match
                    emit('tagIsLoaded', match)
                } else {
                    emit('tagIsLoaded', tags.value[0])
                }
            }
        })
        .catch(err => console.error(err))
}
</script>

<template>
    <listbox v-model="selectedTag">
        <div class="relative">
            <listbox-button>
                <div class="flex items-center gap-2">
                    <filter-tag-label :tag="selectedTag" />
                    {{ selectedTag.title }}
                </div>
            </listbox-button>

            <listbox-options>
                <listbox-option
                    v-for="tag in tags"
                    :key="tag.name"
                    :value="tag"
                >
                    <div class="flex items-center gap-2">
                        <filter-tag-label :tag="tag" />
                        {{ tag.title }}
                    </div>
                </listbox-option>
            </listbox-options>
        </div>
    </listbox>
</template>
