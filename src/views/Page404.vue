<template>
    <Navbar :isLight="false" />

    <div class="container has-text-centered">
        <h2 class="mt-6 is-size-4">😔 Sorry, that page doesn’t exist!</h2>

        <router-link to="/" class="button is-rounded mt-5">About page</router-link>
        <router-link to="/projects" class="button is-rounded mt-5 ml-3">Open source page</router-link>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'

export default defineComponent({
    components: {
        Navbar,
    },
})
</script>