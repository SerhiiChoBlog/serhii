<script setup lang="ts">
import type { Tag } from '../../../../types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { Listbox } from '@headlessui/vue'
import ListboxButton from '../../Listbox/ListboxButton.vue'
import ListboxOptions from '../../Listbox/ListboxOptions.vue'
import ListboxOption from '../../Listbox/ListboxOption.vue'

const tags = ref<Tag[]>([])
const selectedTag = ref<Tag | null>(null)

onMounted(() => fetchTags())

function fetchTags(): void {
    axios.get<Tag[]>('/api/tags')
        .then(resp => {
            tags.value = resp.data
            selectedTag.value = resp.data[0]
        })
        .catch(err => console.error(err))
}
</script>

<template>
    <listbox v-if="selectedTag" v-model="selectedTag">
        <div class="relative">
            <listbox-button class="flex gap-3">
                <div
                    class="py-[3px] inline-block font-white px-2 rounded-md text-white text-xs flex-shrink-0"
                    :style="{ backgroundColor: selectedTag.color }"
                >
                    {{ selectedTag.name }}
                </div>

                <span class="truncate block">{{ selectedTag.title }}</span>
            </listbox-button>

            <listbox-options>
                <listbox-option
                    v-for="tag in tags"
                    :key="tag.name"
                    :value="tag"
                >
                    <div class="flex gap-3">
                        <span
                            class="bg-red-600 py-[3px] inline-block font-white px-2 rounded-md text-white text-xs"
                            :style="{ backgroundColor: tag.color }"
                        >
                            {{ tag.name }}
                        </span>

                        {{ tag.title }}
                    </div>
                </listbox-option>
            </listbox-options>
        </div>
    </listbox>
</template>
