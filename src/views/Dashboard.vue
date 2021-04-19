<template>
    <Navbar :isLight="false" />

    <div class="container has-text-centered">
        <h2 class="mt-6 is-size-4">Dashboard</h2>
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