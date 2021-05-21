<template>
    <div class="social-links">
        <a :href="`https://www.reddit.com/submit?url=${url}&title=${postTitle}`"
            target="_blank"
            rel="nofollow noopener noreferrer"
            @mousedown="saveShare('reddit')"
        >
            <img src="/storage/icons/reddit.png" alt="reddit">
        </a>
        <a :href="`https://www.linkedin.com/sharing/share-offsite/?url=${url}`"
            target="_blank"
            rel="nofollow noopener noreferrer"
            @mousedown="saveShare('linkedin')"
        >
            <img src="/storage/icons/linkedin.png" alt="linked in">
        </a>
        <a :href="`https://twitter.com/intent/tweet?text=${postTitle}&url=${url}`"
            target="_blank"
            rel="nofollow noopener noreferrer"
            @mousedown="saveShare('twitter')"
        >
            <img src="/storage/icons/twitter.png" alt="twitter">
        </a>
        <a :href="`https://www.facebook.com/sharer/sharer.php?u=${url}`"
            target="_blank"
            rel="nofollow noopener noreferrer"
            @mousedown="saveShare('facebook')"
        >
            <img src="/storage/icons/facebook.png" alt="facebook">
        </a>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        postTitle: {
            required: true,
            type: String,
        }
    },

    setup({ postTitle }) {
        const url = window.location.href

        function saveShare(socialMediaName: string): void {
            console.log(socialMediaName)
        }

        return {
            url,
            postTitle,
            saveShare,
        }
    },
})
</script>

<style scoped>

</style>
