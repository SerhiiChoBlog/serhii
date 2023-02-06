<script setup lang="ts">
import { ref } from 'vue'

type Emits = {
    (e: 'posted', comment: string): void
}

const emit = defineEmits<Emits>()
const comment = ref('')

function postComment(): void {
    emit('posted', comment.value)
}
</script>

<template>
    <form @submit.prevent="postComment" class="mt-4 w-full mb-12">
        <textarea
            v-model="comment"
            placeholder="Write a comment..."
            class="py-2 px-4 mb-4 bg-page focus:outline-none dark:bg-page-second rounded-lg border border-border w-full min-h-[135px]"
        ></textarea>

        <button
            type="button"
            class="px-7 py-2.5 bg-main text-white rounded-md hover:bg-main-hover"
        >
            Post comment
        </button>
    </form>
</template>
