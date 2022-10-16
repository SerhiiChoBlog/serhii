<script setup lang="ts">
import type { Tag } from '@/../types/models'
import type { SubscriptionForm, SubscriptionTagsModal } from '@/../types'
import AppearTransition from '@/components/Transitions/AppearTransition.vue'
import { onMounted, reactive } from 'vue'
import axios from 'axios'
import showToast from '@/modules/showToast'
import CheckIcon from '@/components/Icons/CheckIcon.vue'
import Modal from '@/components/Modal.vue'
import SubscriptionModalContent from './SubscriptionModalContent.vue'
import ChooseTagsButton from './ChooseTagsButton.vue'
import SubscriptionButton from '@/modules/Subscription/SubscriptionButton'

type Props = {
    removeBg?: boolean
}

const { removeBg = false } = defineProps<Props>()

const modalForm = reactive<SubscriptionForm>({
    loading: false,
    email: '',
})

const tags = reactive<SubscriptionTagsModal>({
    showModal: false,
    loading: false,
    items: [],
})

const advantages = [
    'No spam',
    'No advertisements, only new posts',
    'Your email is kept private and safe',
    'You can unsubscribe any time',
]

onMounted(() => SubscriptionButton.rename())

function showModalWithTags(): void {
    tags.showModal = true

    if (tags.items.length > 0) {
        return
    }

    tags.loading = true
    SubscriptionButton.setLoading()

    axios.get<Tag[]>('/api/tags')
        .then(resp => {
            tags.items.push(...resp.data)
        })
        .catch(err => console.error(err))
        .finally(() => {
            tags.loading = false
            SubscriptionButton.setAllTags()
        })
}

function subscribe(): void {
    if (modalForm.email === '' || modalForm.loading) {
        return
    }

    modalForm.loading = true

    axios.post<string>(`/api/subscriptions/${modalForm.email}`)
        .then(resp => {
            modalForm.email = ''

            showToast({
                text: resp.data,
                duration: 7000,
            })
        })
        .catch(err => console.error(err))
        .finally(() => modalForm.loading = false)
}
</script>

<template>
    <div>
        <appear-transition>
            <footer
                :class="{ 'bg-gradient-to-r from-gray-800 to-gray-700': !removeBg }"
                class="print:hidden"
            >
                <div class="container grid grid-cols-1 lg:grid-cols-[3fr_2fr] gap-7 md:gap-20 text-white px-8 py-14 lg:py-24 relative z-10">
                    <form @submit.prevent="subscribe" class="w-full lg:w-[550px] mx-auto">
                        <label
                            for="subscription"
                            class="flex flex-col mb-4 drop-shadow-md pl-4"
                        >
                            <span class="text-lg lg:text-2xl">Don't miss the Next article</span>
                            <span class="text-sm lg:text-lg">You can subscribe to specific tags and be notified when it's out</span>
                        </label>

                        <div class="flex h-[45px] lg:h-[53px] bg-gray-600 p-1 inline-block rounded-full shadow-sm">
                            <choose-tags-button
                                class="hidden md:inline-flex"
                                @clicked="showModalWithTags"
                            />

                            <input
                                type="email"
                                id="subscription"
                                class="px-6 h-full bg-transparent rounded-full w-full focus:outline-none text-white placeholder-gray-300"
                                placeholder="Your email address"
                                v-model="modalForm.email"
                            >

                            <button
                                type="submit"
                                class="transition-all hover:px-10 h-full px-4 lg:px-7 rounded-full shadow-md"
                                :class="modalForm.loading ? 'bg-main text-white' : 'bg-white text-gray-700'"
                            >
                                <span v-if="modalForm.loading" class="flex gap-4">
                                    <b class="animate-spin inline-block">/</b>
                                    <span>Processing...</span>
                                </span>
                                <span v-else>Subscribe</span>
                            </button>
                        </div>

                        <div class="md:hidden text-center">
                            <choose-tags-button
                                class="!bg-white !text-font w-full h-10 mt-2 text-center mx-auto"
                                @clicked="showModalWithTags"
                            />
                        </div>
                    </form>

                    <div class="mt-4 text-md lg:text-lg space-y-3">
                        <ul class="space-y-1">
                            <li
                                v-for="item in advantages"
                                :key="item"
                                class="flex gap-2 items-center"
                            >
                                <check-icon class="w-5 lg:w-7 h-5 lg:h-7 text-green-500" />
                                <span>{{ item }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>
        </appear-transition>

        <modal
            v-if="!tags.loading"
            :opened="tags.showModal"
            @close="tags.showModal = false"
        >
            <subscription-modal-content :tags="tags" />
        </modal>
    </div>
</template>
