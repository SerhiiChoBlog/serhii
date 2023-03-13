<script setup lang="ts">
import MainButton from '@admin/components/Buttons/MainButton.vue'
import { ref } from 'vue'
import { Post } from '@shared/types/models'

const postSlug = ref<string>('')
const post = ref<Post | null>(null)

function fetchPost(): void {
    console.log(postSlug.value)
}
</script>

<template>
    <div class="flex gap-4 items-center mt-7">
        <MainButton>
            <i class="fas fa-plus mr-2"></i>
            Add post
        </MainButton>

        <input
            type="text"
            placeholder="Post slug"
            class="px-5 py-2 rounded-md bg-page-second w-full max-w-[250px]"
            v-model="postSlug"
            @blur="fetchPost"
        />

        <i v-if="post" class="fas fa-check text-green-500 text-2xl"></i>
        <i v-else class="fas fa-times text-red-500 text-2xl"></i>

        <span v-if="post">{{ post.title }}</span>
        <span v-else>No post</span>
    </div>
</template>
