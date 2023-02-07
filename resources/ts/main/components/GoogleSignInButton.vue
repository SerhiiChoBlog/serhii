<script setup lang="ts">
import type { User } from '@shared/types/models'
import { ref } from 'vue'
import getAccessToken from '@/firebase/getAccessToken'
import showToast from '@shared/modules/showToast'
import axios from 'axios'
import Spinner from '@shared/components/Icons/Spinner.vue'
import handleServerError from '@shared/modules/handleServerError'

const isLoading = ref<boolean>(false)

function signIn(): void {
    isLoading.value = true

    getAccessToken(accessToken => makeRequestToSignInUser(accessToken), (err) => {
        console.log(err)
        isLoading.value = false
    })
}

function makeRequestToSignInUser(accessToken: string): void {
    const params = {
        access_token: accessToken,
    }

    axios.post<User | string>('/google-sign-in', params)
        .then(resp => handleResponse(resp.data))
        .catch(handleServerError)
        .finally(() => isLoading.value = false)
}

function handleResponse(user: User | string): void {
    if (typeof user === 'string') {
        showToast({ text: user })
        return
    }

    if (!user) {
        return
    }

    showToast({ text: `Signed in successfully as ${user.name}` })

    window.location.reload()
}
</script>

<template>
    <button
        @click="signIn"
        type="button"
        class="rounded-full w-8 h-8 transition-transform transform hover:-translate-y-1"
        :class="{ 'is-loading dark': isLoading }"
        :disabled="isLoading"
        title="Sign in with Google"
    >
        <spinner v-if="isLoading" class="w-8 h-8" />

        <img
            v-else
            src="/storage/icons/google.webp"
            alt="Google logo"
            width="100"
            height="100"
            class="w-full"
        />
    </button>
</template>
