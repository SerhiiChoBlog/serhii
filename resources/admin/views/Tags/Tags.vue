<script setup lang="ts">
import PageTitle from '../../components/PageTitle.vue'
import MainButton from '../../components/Buttons/MainButton.vue'
import { ref } from 'vue'
import type { Tag } from '../../../types/models'

const tags = ref<Tag[]>([])
</script>

<template>
    <div class="container">
        <page-title>
            <div class="flex items-center justify-center gap-3">
                <span>Tags</span>

                <main-button type="button" :route="{ name: 'create-tag' }" title="Add new tag">
                    <i class="fas fa-plus"></i>
                </main-button>
            </div>
        </page-title>

        <div class="mt-5">
            <h2 v-if="tags.length === 0" class="text-center text-xl mt-6">
                There are not tags
            </h2>

            <div v-else class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-500 text-left">
                    <tr>
                        <th
                            v-for="title in ['Title', 'Slug', 'Posts', 'Color', 'Tag', 'Description', '']"
                            :key="title"
                            class="text-white p-3 font-light"
                        >
                            {{ title }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100">
                            <td class="px-3 py-2">{{ tag.title }}</td>
                            <td class="px-3 py-2">{{ tag.name }}</td>
                            <td class="px-3 py-2">{{ tag.posts_count }}</td>
                            <td class="px-3 py-2">
                                <input
                                    type="text"
                                    :value="tag.color"
                                    class="w-[80px] text-center rounded-md bg-gray-200"
                                >
                            </td>
                            <td class="px-3 py-2">
                                <a
                                    :href="`/posts?tag=${tag.name}`"
                                    class="py-[3px] inline-block font-white px-2 rounded-md text-white text-xs"
                                    :style="{ backgroundColor: tag.color }"
                                >
                                    {{ tag.name }}
                                </a>
                            </td>
                            <td class="px-3 py-2">
                                {{ tag.description }}
                            </td>
                            <td class="px-3 py-2">
                                <router-link
                                    :to="{ name: 'edit-tag', params: { id: tag.id } }"
                                    class="text-font-second inline-block text-xs transition-colors hover:text-main-dark p-1"
                                    title="Edit tag"
                                >
                                    <i class="fas fa-pen"></i>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
