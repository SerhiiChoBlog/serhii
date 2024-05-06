<script setup lang="ts">
import { ref, watchEffect } from 'vue'
import ShowPasswordButton from '@/components/ShowPasswordButton.vue'
import ValidationMessage from '@/components/Form/ValidationMessage.vue'

const modelValue = defineModel<string>()

type Props = {
    name: string
    id: string
    errorMessage?: string | null
    type?: 'text' | 'email' | 'password' | 'checkbox'
    placeholder?: string
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
})
</script>

<template>
    <div class="relative">
        <input
            :type="props.type"
            :placeholder="props.placeholder"
            class="w-full px-4 py-3 border bg-page-second rounded-md focus:outline-none focus:ring-1 focus:ring-main"
            @input="inputHandler"
            :class="{
                'border-red-600/50': props.errorMessage,
                'border-border': !props.errorMessage,
            }"
            :name="props.name"
            v-model="modelValue"
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
