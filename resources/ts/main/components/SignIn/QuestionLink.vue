<script setup lang="ts">
type Emits = {
    (e: 'clicked'): void
}

type Props = {
    question: string
    title: string
}

const emit = defineEmits<Emits>()
const props = defineProps<Props>()
</script>

<template>
    <span class="flex flex-col text-center">
        <span class="text-sm text-font">{{ props.question }}</span>

        <button
            @click="emit('clicked')"
            class="text-sm text-main hover:underline uppercase"
            rel="noreferrer"
        >
            {{ props.title }}
        </button>
    </span>
</template>
