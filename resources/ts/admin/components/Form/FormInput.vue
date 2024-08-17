<script setup lang="ts">
import LetterCounter from './LetterCounter.vue'
import { ref, watchEffect } from 'vue'

type Props = {
    id: string
    type: string
    placeholder?: string
    value?: string
    length?: number
    classes?: string
    name?: string
    min?: number
    max?: number
}

type Emits = {
    (e: 'changed', value: string): void
}

const emit = defineEmits<Emits>()
const props = defineProps<Props>()
const inputValue = ref<string>('')

watchEffect(() => {
    inputValue.value = props.value || ''
})
</script>

<template>
    <div class="inline-block w-full">
        <label :for="props.id" class="font-bold text-sm mb-2 text-font-second block">
            <slot />
        </label>

        <div class="inline-block relative w-full">
            <input
                :type="props.type"
                class="border border-border bg-page-second py-3 px-4 rounded-md w-full"
                :class="props.classes"
                :placeholder="props.placeholder"
                v-model="inputValue"
                :name="props.name"
                :id="props.id"
                autocomplete="off"
                @input="emit('changed', inputValue)"
                :min="props.min"
                :max="props.max"
            />

            <letter-counter
                v-if="props.length"
                :length="props.length"
                :inputValue="inputValue"
            />

            <slot name="input" />
        </div>
    </div>
</template>
