<script setup lang="ts">
import { ref } from 'vue'

interface Props {
    isLight: boolean
}

const { isLight } = defineProps<Props>()
const isActive = ref(false)

function toggleNavbar(): void {
    const navbar = document.getElementById('navbar-menu')

    if (!navbar)
        return

    if (navbar.classList.contains('is-active')) {
        navbar.classList.remove('is-active')
        isActive.value = false
    } else {
        navbar.classList.add('is-active')
        isActive.value = true
    }
}
</script>


<template>
    <a role="button"
       class="flex flex-col gap-y-[3px] opacity-80"
       :class="{ 'text-white': isLight, 'is-active': isActive }"
       @click="toggleNavbar"
    >
        <span v-for="i in 3" :key="i" aria-hidden="true" class="w-[19px] h-[2px] block bg-white"></span>
    </a>
</template>
