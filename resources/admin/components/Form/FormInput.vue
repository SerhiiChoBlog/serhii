<script setup lang="ts">
import LetterCounter from './LetterCounter.vue'
import { ref } from 'vue'

type Props = {
    id: string
    type: string
    placeholder: string
    length?: number
    error?: string
    classes?: string
}

const { id, type, placeholder, length, error, classes } = defineProps<Props>()
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
            />

            <span v-if="error" class="text-sm text-red-700">{{ error }}</span>

            <letter-counter v-if="length" :length="length" :inputValue="inputValue" />
        </div>
    </div>
</template>

