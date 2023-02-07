<script setup lang="ts">
import { User } from '@shared/types/models'
import Tip from '@shared/components/Tip.vue'

type Props = {
    user: User
}

const { user } = defineProps<Props>()
</script>

<template>
    <div class="relative">
        <img
            :src="`/storage/avatars/${user.avatar}`"
            :alt="`${user.name}'s avatar`"
            width="200"
            height="200"
            class="w-full max-w-[250px] mx-auto lg:mx-0 rounded-full shadow-lg pointer-events-none"
        />

        <tip
            :content="`Signed in with ${user.sign_in_method}`"
            class="absolute bottom-0 right-5 md:right-14"
        >
            <img
                :src="`/storage/icons/${user.sign_in_method}.webp`"
                :alt="`${user.sign_in_method}'s logo`"
                width="50"
                height="50"
                class="bg-white rounded-full p-0.5 shadow-md"
            />
        </tip>
    </div>
</template>
