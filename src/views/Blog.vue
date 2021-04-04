<template>
    <Navbar/>
    <div class="container">
        <h1 class="is-h1">This is an open source page</h1>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from "@/inc/Navbar.vue"

export default defineComponent({
    components: {
        Navbar,
    },
})
</script>

