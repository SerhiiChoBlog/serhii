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

<script lang="ts">
import { defineComponent, ref } from 'vue'

export default defineComponent({
    props: {
        isLight: {
            required: false,
            type: Boolean,
            default: false,
        },
    },

    setup({ isLight }) {
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

        return {
            isLight,
            isActive,
            toggleNavbar,
        }
    },
})
</script>

<style scoped>

</style>
