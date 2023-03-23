<script setup lang="ts">
import { computed } from 'vue'
import ShowPasswordButton from '@/components/ShowPasswordButton.vue'
import ValidationMessage from '@/components/Form/ValidationMessage.vue'

type Emits = {
    (e: 'update:modelValue', value: string | boolean): void
}

const emit = defineEmits<Emits>()

type Props = {
    name: string
    modelValue: string | boolean
    errorMessage?: string | null
    value?: string
    id?: string
    type?: 'text' | 'email' | 'password' | 'checkbox'
    placeholder?: string
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
    value: '',
    id: '',
})

const inpValue = computed({
    get: () => props.modelValue,
    set: (v: string | boolean) => emit('update:modelValue', v),
})
</script>

<template>
    <div class="relative">
        <input
            :type="props.type"
            :placeholder="props.placeholder"
            class="w-full px-4 py-3 border bg-page-second rounded-md focus:outline-none focus:ring-1 focus:ring-main"
            :class="{
                'border-red-600/50': props.errorMessage,
                'border-border': !props.errorMessage,
            }"
            :name="props.name"
            v-model="inpValue"
            :id="props.id"
            :ref="`ref-${props.name}`"
        >

        <show-password-button
            v-if="props.type === 'password'"
            :input-id="props.id"
        />
    </div>

    <validation-message :message="props.errorMessage" />
</template>
