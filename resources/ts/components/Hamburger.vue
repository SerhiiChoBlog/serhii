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
       class="navbar-burger"
       :class="{ 'burger-light': isLight, 'is-active': isActive }"
       @click="toggleNavbar"
    >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
    </a>
</template>
