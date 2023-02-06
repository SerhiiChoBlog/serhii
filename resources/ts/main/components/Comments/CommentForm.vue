<script setup lang="ts">
import CommentInput from './CommentInput.vue'</script>

<template>
    <form class="space-y-2 mt-4">
        <comment-input
            type="text"
            id="comment-name"
            placeholder="Example: John Doe"
        >Your name</comment-input>

        <comment-input
            type="email"
            id="comment-email"
            placeholder="Example: jogndoe@mail.com"
        >Your email</comment-input>
    </form>
</template>
