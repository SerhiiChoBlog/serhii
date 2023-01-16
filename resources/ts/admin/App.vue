<script setup lang="ts">
import UserSidebar from './components/UserSidebar.vue'
</script>

<template>
    <user-sidebar />

    <div class="pl-9 lg:pl-14 py-10 text-font font-main bg-page">
        <router-view />
    </div>
</template>
