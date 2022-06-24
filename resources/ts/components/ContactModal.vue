<script setup lang="ts">
import { onMounted, ref } from 'vue'
import contactModalSections from '../modules/contactModalSections'

const isOpen = ref(false)

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

    <transition
        enter-active-class="duration-300 ease-out"
        enter-from-class="transform opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="transform opacity-0"
    >
        <div v-show="isOpen" class="fixed left-0 right-0 top-0 bottom-0 z-20 bg-[hsla(0,0%,4%,.86)]">
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
                        <div v-for="section in contactModalSections" :key="section.title" class="py-5 first:pt-0 last:pb-0">
                            <h3 class="text-center text-2xl mb-3 font-arizona font-bold">{{ section.title }}</h3>
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

            <button class="modal-close is-large" aria-label="close" @click="closeContactModal"></button>
        </div>
    </transition>
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
