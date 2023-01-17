<script setup lang="ts">
import type { Post } from '@shared/types/models'
import IconButton from '@admin/components/Buttons/IconButton.vue'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
</script>

<template>
    <tr class="border-b border-border odd:bg-page-second">
        <td class="p-3 text-lg">
            <i v-if="post.is_published" class="fas fa-check text-green-600"></i>
            <i v-else class="fas fa-times text-red-600"></i>
        </td>
        <td class="p-1">
            <a :href="`/${post.image_lg}`" target="_blank" rel="noreferrer">
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
        <td class="p-3 text-center">{{ post.post_views_count }}</td>
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
                :route="{ name: 'posts-edit', params: { id: post.id.toString() } }"
                title="Edit post"
            />
        </td>
    </tr>
</template>
