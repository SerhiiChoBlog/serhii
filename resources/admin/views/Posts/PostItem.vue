<script setup lang="ts">
import type { Post } from '../../../types/models'
import IconButton from '../../components/Buttons/IconButton.vue'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
</script>

<template>
    <tr class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100">
        <td class="p-3 text-lg">
            <i v-if="post.is_published" class="fas fa-check text-green-600"></i>
            <i v-else class="fas fa-times text-red-600"></i>
        </td>
        <td class="p-1">
            <a :href="`/${post.image_lg}`" target="_blank">
                <img
                    :src="`/${post.image_sm}`"
                    width="300"
                    class="rounded-md shadow-md"
                    :alt="post.title"
                />
            </a>
        </td>
        <td class="p-3 text-xl leading-6">{{ post.title }}</td>
        <td class="p-3 text-sm">{{ post.intro || '-' }}</td>
        <td class="p-3 text-center">{{ post.social_shares_count }}</td>
        <td class="p-3 text-center">{{ post.page_views_count }}</td>
        <td class="p-3 text-center">
            <icon-button
                icon="fa-eye"
                :href="`/posts/${post.slug}`"
                title="View post"
            />
        </td>
        <td class="p-3 text-center">
            <icon-button
                icon="fa-pen"
                :route="{ name: 'edit-post', params: { id: post.id } }"
                title="Edit post"
            />
        </td>
    </tr>
</template>
