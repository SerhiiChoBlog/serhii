<script setup lang="ts">
import { onMounted, ref } from 'vue'
import Tip from '@/components/Tip.vue'

type Props = {
    inputId: string
}

const { inputId } = defineProps<Props>()
const input = ref<HTMLInputElement | null>(null)

onMounted(() => {
    const elem = document.getElementById(inputId) as HTMLInputElement | null

    if (elem) {
        input.value = elem
    }
})

function changeInputType(): void {
    if (!input.value) {
        return
    }

    input.value.type = input.value.type === 'text' ? 'password' : 'text'
}
</script>

<template>
    <tip content="Show / hide password">
        <button
            class="absolute right-2 top-1/2 -translate-y-1/2 px-1 text-gray-500 transition-colors hover:text-black"
            @click="changeInputType"
            type="button"
        >
            x
        </button>
    </tip>
</template>
