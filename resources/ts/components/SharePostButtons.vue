<script setup lang="ts">
import axios from 'axios'

interface Props {
    postTitle: string
    postId: number
}

const { postTitle, postId } = defineProps<Props>()
const url = window.location.href
const links = [
    {
        href: `https://www.reddit.com/submit?url=${url}&title=${postTitle}`,
        title: 'reddit',
    },
    {
        href: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
        title: 'linkedin',
    },
    {
        href: `https://twitter.com/intent/tweet?text=${postTitle}&url=${url}`,
        title: 'twitter',
    },
    {
        href: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
        title: 'facebook',
    },
]

function saveShare(social: string): void {
    axios.post(`/api/social-shares/${postId}`, { social })
        .then(resp => console.log(resp.data))
        .catch(err => console.error(err))
}
</script>

<template>
    <div class="flex space-x-5">
        <a v-for="link in links"
            :key="link.title"
            :href="link.href"
            target="_blank"
            rel="nofollow noopener noreferrer"
            @mousedown="saveShare(link.title)"
        >
            <img :src="`/storage/icons/${link.title}.png`"
                :alt="link.title"
                width="35"
            >
        </a>
    </div>
</template>
