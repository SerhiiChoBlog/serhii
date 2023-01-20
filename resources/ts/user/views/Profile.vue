<script setup lang="ts">
import type { User } from '@shared/types/models'
import { ref } from 'vue'

const user = ref<User>(Auth)

function fetchUser(): void {
    console.log('nice')
}
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div>
            <img
                :src="`/storage/avatars/${user.avatar}`"
                :alt="`${user.name}'s avatar`"
                width="200"
                height="200"
                class="rounded-full shadow-lg"
            />
        </div>

        <div>
            <h2 class="text-black">
                Profile page is here
            </h2>
        </div>
    </div>
</template>
