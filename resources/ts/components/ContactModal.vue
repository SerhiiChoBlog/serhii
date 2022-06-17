<script setup lang="ts">
import { onMounted, ref } from 'vue'

const isOpen = ref(false)
const sections = [
    {
        title: 'Contact me',
        content: `
        The fastest way to contact me is to send me an email at
        <a href="mailto:serhiicho@protonmail.com" class="text-main">serhiicho@protonmail.com</a> or text me on Linkedin. Before you send me a message, make sure you've read
        <a href="/about-me" class="text-main" target="_blank">about me</a> page. Don't ignore this, it's very important.
        `,
        links: [
            {
                img: '/storage/icons/linkedin.png',
                href: 'https://www.linkedin.com/in/serhiicho',
                title: 'LinkedIn',
            },
            {
                img: '/storage/icons/instagram.png',
                href: 'https://www.instagram.com/serhiicho',
                title: 'Instagram',
            },
            {
                img: '/storage/icons/twitter.png',
                href: 'https://twitter.com/SerhiiCho',
                title: 'Twitter',
            },
        ],
    },
    {
        title: 'Find me',
        content: "There are some places where I'm usually hanging out. I spend a lot of time on websites that are linked below.",
        links: [
            {
                img: '/storage/icons/github-dark.png',
                href: 'https://github.com/SerhiiCho',
                title: 'GitHub',
            },
            {
                img: '/storage/icons/laracasts.png',
                href: 'https://laracasts.com/@SerhiiCho',
                title: 'Laracasts',
            },
            {
                img: '/storage/icons/codewars.png',
                href: 'https://www.codewars.com/users/serhii_cho',
                title: 'Codewars',
            },
            {
                img: '/storage/icons/codepen.png',
                href: 'https://codepen.io/serhii_cho',
                title: 'Codepen',
            },
        ],
    },
    {
        title: 'Open source',
        content: "There are also libraries and packages that I've contributed to the open-source community. Some of them you can find by links below.",
        links: [
            {
                img: '/storage/icons/packagist.png',
                href: 'https://packagist.org/packages/serhii',
                title: 'Packagist',
            },
            {
                img: '/storage/icons/npm.png',
                href: 'https://www.npmjs.com/~serhiicho',
                title: 'NPM',
            },
        ],
    },
]

function openContactModal(): void {
    isOpen.value = true
}

function closeContactModal(): void {
    isOpen.value = false
}

onMounted(() => {
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeContactModal()
        }
    })
})
</script>

<template>
    <div class="p-7 lg:p-0">
        <button type="button"
            class="w-full lg:w-auto text-white bg-main py-2 px-6 rounded-full hover:bg-main-hover transition-colors"
            @click="openContactModal"
        >
            Contact me
        </button>
    </div>

    <div class="fixed left-0 right-0 top-0 bottom-0 z-20 bg-[hsla(0,0%,4%,.86)]" v-show="isOpen">
        <transition name="fade">
            <div v-if="isOpen"
                 class="overflow-y-scroll absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[1000px] mx-auto max-h-[calc(100vh-40px)]"
            >
                <div class="bg-page text-font shadow-xl rounded-lg p-10 h-full relative">
                    <!-- Close modal button -->
                    <button @click="closeContactModal"
                        type="button"
                        class="absolute top-2 right-2 p-3 text-font-second hover:text-main transition-colors"
                    >
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </button>

                    <div class="divide-y divide-border">
                        <div v-for="section in sections" :key="section.title" class="py-5 first:pt-0 last:pb-0">
                            <h3 class="text-center text-2xl mb-3">{{ section.title }}</h3>
                            <p v-html="section.content" class="text-center text-lg"></p>

                            <div class="flex justify-center gap-x-5 mt-5">
                                <a
                                    v-for="link in section.links"
                                    :key="link.title"
                                    :href="link.href"
                                    target="_blank"
                                    :title="link.title"
                                    class="transition-transform hover:scale-125"
                                >
                                    <img :src="link.img" :alt="link.title" width="30"/>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </transition>

        <button class="modal-close is-large" aria-label="close" @click="closeContactModal"></button>
    </div>
</template>

<style lang="sass" scoped>
.modal
    .box
        margin: 10px
        padding: 30px

.modal-content
    width: 100%
    max-width: 1000px
</style>
