<script setup lang="ts">
import type { Tag } from '../../../../types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { Listbox } from '@headlessui/vue'
import ListboxButton from '../../Listbox/ListboxButton.vue'
import ListboxOptions from '../../Listbox/ListboxOptions.vue'
import ListboxOption from '../../Listbox/ListboxOption.vue'
import FilterTagLabel from './FilterTagLabel.vue'

const tags = ref<Tag[]>([
    {
        id: 0,
        title: '--- Choose tag ---',
        description: '',
        name: 'unknown',
        color: 'no',
    },
])

const selectedTag = ref<Tag>(tags.value[0])

onMounted(() => fetchTags())

function fetchTags(): void {
    axios.get<Tag[]>('/api/tags')
        .then(resp => tags.value.push(...resp.data))
        .catch(err => console.error(err))
}
</script>

<template>
    <listbox v-model="selectedTag">
        <div class="relative">
            <listbox-button>
                <div class="flex gap-2">
                    <filter-tag-label v-if="selectedTag.color !== 'no'" :tag="selectedTag" />
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
                        <filter-tag-label v-if="tag.color !== 'no'" :tag="tag" />
                        {{ tag.title }}
                    </div>
                </listbox-option>
            </listbox-options>
        </div>
    </listbox>
</template>
