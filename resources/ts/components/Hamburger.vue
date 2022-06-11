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
       class="block ml-auto relative w-[3.25rem] h-[3.25rem] transition-transform duration-300 delay-300"
       :class="isActive ? 'rotate-45' : ''"
       @click="toggleNavbar"
    >
        <span aria-hidden="true"
            class="w-[19px] h-[2px] block bg-white rounded-full absolute left-[calc(50%-8px)] transition-all duration-500"
            :class="isActive ? 'rotate-[-90deg] top-[calc(50%-1.5px)]' : 'top-[calc(50%-6px)]'"
        ></span>

        <span aria-hidden="true"
            class="w-[19px] h-[2px] block bg-white rounded-full absolute top-[calc(50%-1px)] left-[calc(50%-8px)] transition-all duration-500"
            :class="isActive ? '' : ''"
        ></span>

        <span aria-hidden="true"
            class="w-[19px] h-[2px] block bg-white rounded-full absolute top-[calc(50%+4px)] left-[calc(50%-8px)] transition-all duration-500"
            :class="isActive ? 'translate-y-[40px] opacity-0' : ''"
        ></span>
    </a>
</template>
