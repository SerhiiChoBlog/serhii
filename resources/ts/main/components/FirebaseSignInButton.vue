<script setup lang="ts">
import type { User } from '@shared/types/models'
import type { FirebaseSignUpRequest } from '@shared/types'
import { ref } from 'vue'
import getGoogleUser from '@/firebase/getGoogleUser'
import getGithubUser from '@/firebase/getGithubUser'
import showToast from '@shared/modules/showToast'
import axios from 'axios'
import Spinner from '@shared/components/Icons/Spinner.vue'
import handleServerError from '@shared/modules/handleServerError'
import Tip from '@shared/components/Tip.vue'

type Props = {
    serviceName: 'google' | 'github'
}

const { serviceName } = defineProps<Props>()
const isLoading = ref<boolean>(false)
console.log(serviceName)

function signIn(): void {
    isLoading.value = true

    if (serviceName === 'github') {
        getGithubUser(makeRequestToSignInUser, handleError)
    } else {
        getGoogleUser(makeRequestToSignInUser, handleError)
    }
}

function handleError(err: any): void {
    console.log(err)
    isLoading.value = false
}

function makeRequestToSignInUser(params: FirebaseSignUpRequest): void {
    axios.post<User | string>('/firebase-sign-in', params)
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
        class="rounded-full w-8 h-8 transition-transform transform hover:scale-110 flex items-center"
        :disabled="isLoading"
    >
        <spinner v-if="isLoading" class="w-8 h-8" />

        <tip v-else content="Sign in with Google" class="inline-flex">
            <img
                :src="`/storage/icons/${serviceName}.webp`"
                :alt="`${serviceName} logo`"
                width="100"
                height="100"
                class="w-full"
            />
        </tip>
    </button>
</template>
