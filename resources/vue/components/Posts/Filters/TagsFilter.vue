<script setup lang="ts">
import type { Tag } from '../../../../types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { Listbox } from '@headlessui/vue'
import ListboxButton from '../../Listbox/ListboxButton.vue'
import ListboxOptions from '../../Listbox/ListboxOptions.vue'
import ListboxOption from '../../Listbox/ListboxOption.vue'
import FilterTagLabel from './FilterTagLabel.vue'

type Props = {
    tagSlug: string
}

const { tagSlug } = defineProps<Props>()

const tags = ref<Tag[]>([
    {
        id: 0,
        title: 'Show everything',
        description: '',
        name: 'everything',
        color: '#7F6084',
    },
])

const selectedTag = ref<Tag>(tags.value[0])

onMounted(() => fetchTags())

function fetchTags(): void {
    axios.get<Tag[]>('/api/tags')
        .then(resp => {
            tags.value.push(...resp.data)

            if (tagSlug) {
                const match = resp.data.find(tag => tag.name === tagSlug.trim())

                if (match) {
                    selectedTag.value = match
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
                <div class="flex gap-2">
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
                    <div class="flex gap-2">
                        <filter-tag-label :tag="tag" />
                        {{ tag.title }}
                    </div>
                </listbox-option>
            </listbox-options>
        </div>
    </listbox>
</template>
