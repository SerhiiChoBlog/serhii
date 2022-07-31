<script setup lang="ts">
import axios from 'axios'
import copy from 'copy-to-clipboard'
import showToast from '../modules/showToast'
import Tip from '../components/Tip.vue'

interface Props {
    postTitle: string
    postId: number
}

const { postTitle, postId } = defineProps<Props>()
const url = window.location.href
const links = [
    {
        href: `https://twitter.com/intent/tweet?text=${postTitle}&url=${url}`,
        title: 'twitter',
        tip: 'Share to Twitter',
    },
    {
        href: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
        title: 'linkedin',
        tip: 'Share to LinkedIn',
    },
    {
        href: `https://www.reddit.com/submit?url=${url}&title=${postTitle}`,
        title: 'reddit',
        tip: 'Share to Reddit',
    },
    {
        href: `https://t.me/share/url?url=${url}&text=${postTitle}`,
        title: 'telegram',
        tip: 'Share to Telegram',
    },
    {
        href: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
        title: 'facebook',
        tip: 'Share to Facebook',
    },
    {
        href: null,
        title: 'clipboard',
        tip: 'Copy to a clipboard',
        action: () => {
            copy(window.location.href)

            showToast({
                text: 'Current URL has been copied to your clipboard',
                success: true,
            })
        },
    },
]

function saveShare(social: string): void {
    axios.post(`/api/social-shares/${postId}`, { social })
        .catch(err => console.error(err))
}
</script>

<template>
    <div class="flex gap-x-4">
        <tip
            :content="link.tip"
            v-for="link in links"
            :key="link.title"
            class="transition-opacity hover:opacity-80"
        >
            <a
                :href="link.href ? link.href : 'javascript:'"
                :target="link.href ? '_blank' : null"
                rel="nofollow noopener noreferrer"
                @mousedown="saveShare(link.title)"
                @click="link.action ? link.action() : null"
            >
                <img
                    :src="`/storage/icons/${link.title}.webp`"
                    :alt="`Logo of the ${link.title}`"
                    width="30"
                    height="30"
                >
            </a>
        </tip>
    </div>
</template>
