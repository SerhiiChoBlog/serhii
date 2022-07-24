<script setup lang="ts">
import type { Post } from '../../../types/models'

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
            <a href="{{ asset($post->image_lg) }}" target="_blank">
                <img src="{{ asset($post->image_sm) }}"
                     width="300"
                     class="rounded-md shadow-md"
                     alt="{{ $post->title }}"
                />
            </a>
        </td>
        <td class="p-3 text-xl leading-6">{{ $post->title }}</td>
        <td class="p-3 text-sm">{{ $post->intro ?? '-' }}</td>
        <td class="p-3 text-center">{{ $post->social_shares_count }}</td>
        <td class="p-3 text-center">{{ $post->page_views_count }}</td>
        <td class="p-3 text-center">
            <a href="{{ route('posts.show', $post) }}"
               class="text-sm border rounded-sm w-10 h-10 flex justify-center items-center transition-colors hover:bg-gray-100"
               title="View post"
               target="_blank"
            >
                <i class="fas fa-eye"></i>
            </a>
        </td>
        <td class="p-3 text-center">
            <a href="{{ route('admin.posts.edit', $post) }}"
               class="text-sm border rounded-sm w-10 h-10 flex justify-center items-center transition-colors hover:bg-gray-100"
               title="Edit post"
            >
                <i class="fas fa-pen"></i>
            </a>
        </td>
    </tr>
</template>
