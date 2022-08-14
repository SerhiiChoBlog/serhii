<script setup lang="ts">
import AppearTransition from '../Transitions/AppearTransition.vue'
import { ref } from 'vue'
import axios from 'axios'
import showToast from '../../modules/showToast'

const email = ref<string>('')
const loading = ref(false)

function subscribe(): void {
    if (email.value === '' || loading.value) {
        return
    }

    loading.value = true

    axios.post(`/api/subscription/${email.value}`)
        .then(resp => {
            console.log(resp.data)
            email.value = ''
            showToast({
                text: 'Please, check you email to confirm your subscription',
                duration: 7000,
            })
        })
        .catch(err => console.error(err))
        .finally(() => loading.value = false)
}
</script>

<template>
    <appear-transition>
        <footer class="bg-gradient bg-gradient-to-r from-gray-800 to-gray-700 text-white px-8 py-24 relative z-10">
            <form @submit.prevent="subscribe" class="w-[480px] mx-auto">
                <label
                    for="subscription"
                    class="block mb-4 text-2xl text-center drop-shadow-md"
                >
                    Subscribe to get the latest posts
                </label>

                <div class="flex h-[53px] bg-gray-600 p-1 inline-block rounded-full shadow-sm">
                    <input
                        type="email"
                        id="subscription"
                        class="px-6 h-full bg-transparent rounded-full w-full focus:outline-none text-white placeholder-gray-300"
                        placeholder="Your email address"
                        v-model="email"
                    >

                    <button
                        type="submit"
                        class="bg-white transition-all hover:px-10 h-full text-gray-700 px-7 rounded-full"
                    >
                        <span v-if="loading">Processing...</span>
                        <span v-else>Subscribe</span>
                    </button>
                </div>
            </form>
        </footer>
    </appear-transition>
</template>
