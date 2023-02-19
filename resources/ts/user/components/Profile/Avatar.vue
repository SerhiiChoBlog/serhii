<script setup lang="ts">
import { User } from '@shared/types/models'
import SignedInMethodLogo from '@/components/SignedInMethodLogo.vue'
import AppearTransition from '@shared/components/Transitions/AppearTransition.vue'

type Props = {
    user: User
}

const { user } = defineProps<Props>()
</script>

<template>
    <appear-transition>
        <div class="relative">
            <img
                :src="`/storage/avatars/${user.avatar}`"
                :alt="`${user.name}'s avatar`"
                width="200"
                height="200"
                class="w-full max-w-[250px] mx-auto lg:mx-0 rounded-full shadow-lg pointer-events-none"
            />

            <signed-in-method-logo
                :src="`/storage/icons/${user.sign_in_method}.webp`"
                :method="user.sign_in_method"
                class="absolute bottom-0 right-5 md:right-14 w-14 h-14"
            />
        </div>
    </appear-transition>
</template>
