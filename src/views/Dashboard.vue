<template>
    <Navbar :isLight="false" />

    <div class="container has-text-centered">
        <h2 class="mt-6 is-size-4">Dashboard</h2>

        <div class="mt-6">
            <button class="button is-rounded" @click="logout" :class="{ 'is-loading': processingLogout }">Logout</button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'
import useLogout from '@/composables/auth/useLogout'

export default defineComponent({
    setup() {
        return {
            ...useLogout(),
        }
    },

    components: {
        Navbar,
    },
})
</script>