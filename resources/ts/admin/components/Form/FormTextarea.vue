<script setup lang="ts">
import LetterCounter from './LetterCounter.vue'
import { ref } from 'vue'

type Props = {
    id: string
    placeholder: string
    value?: string
    name?: string
    length?: number
    classes?: string
}

type Emits = {
    (e: 'changed', value: string): void
}

const emit = defineEmits<Emits>()
const { id, placeholder, length, value, classes, name } = defineProps<Props>()
const inputValue = ref<string>(value || '')
</script>

<template>
    <div class="inline-block w-full">
        <label :for="id" class="font-bold text-sm mb-2 text-font-second block">
            <slot />
        </label>

        <div class="inline-block relative w-full">
            <textarea
                class="border border-border bg-page-second py-3 px-4 rounded-md w-full"
                :class="classes"
                :placeholder="placeholder"
                v-model="inputValue"
                :name="name"
                :id="id"
                @keyup="emit('changed', inputValue)"
            ></textarea>

            <letter-counter
                v-if="length"
                :length="length"
                :inputValue="inputValue"
            />
        </div>
    </div>
</template>
