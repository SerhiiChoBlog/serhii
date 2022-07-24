<script setup lang="ts">
import LetterCounter from './LetterCounter.vue'
import { ref } from 'vue'

type Props = {
    id: string
    type: string
    placeholder: string
    length?: number
    classes?: string
}

type Emits = {
    (e: 'changed', value: string): void
}

const emit = defineEmits<Emits>()
const { id, type, placeholder, length, classes } = defineProps<Props>()
const inputValue = ref<string>('')
</script>

<template>
    <div class="inline-block w-full">
        <label :for="id" class="font-bold text-sm mb-2 text-font-second block">
            <slot />
        </label>

        <div class="inline-block relative w-full">
            <input
                :type="type"
                class="border py-3 px-4 rounded-md w-full"
                :class="classes"
                :placeholder="placeholder"
                v-model="inputValue"
                :id="id"
                @keyup="emit('changed', inputValue)"
            />

            <letter-counter v-if="length" :length="length" :inputValue="inputValue" />
        </div>
    </div>
</template>

