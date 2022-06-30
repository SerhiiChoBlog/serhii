<script setup lang="ts">
import { ref } from 'vue'
import AppearTransition from './Transitions/AppearTransition.vue'

const shadows = {
    normal: 'box-shadow: rgba(50,50,93,.25) 0 13px 27px -5px, rgba(0,0,0,.3) 0 8px 16px -8px',
    active: 'box-shadow: rgba(0,0,0,.3) 0px 19px 38px, rgba(0,0,0,.22) 0 15px 12px; transform: scale(1.03)',
}

const shadow = ref(shadows.normal)

document.addEventListener('scroll', () => {
    shadow.value = window.scrollY > 310
        ? shadows.active
        : shadows.normal
})
</script>

<template>
    <appear-transition>
        <img
            src="/storage/serhii.jpg"
            alt="Serhii Cho"
            class="my-0 my-auto rounded-lg sticky top-6 mb-6 mt-6 mx-auto transition-all duration-500"
            :style="shadow"
            width="250"
            height="250"
        />
    </appear-transition>
</template>
