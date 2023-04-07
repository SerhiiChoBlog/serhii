<script setup lang="ts">
import { ref } from 'vue'
import ShowPasswordButton from '@/components/ShowPasswordButton.vue'
import ValidationMessage from '@/components/Form/ValidationMessage.vue'

type Emits = {
    (e: 'changed', value: string): void
}

const emit = defineEmits<Emits>()

type Props = {
    name: string
    errorMessage?: string | null
    value?: string
    id: string
    type?: 'text' | 'email' | 'password' | 'checkbox'
    placeholder?: string
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
    value: '',
})

const inputValue = ref<string>(props.value)

function handleChange() {
    emit('changed', inputValue.value)
}
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
            @input="handleChange"
            v-model="inputValue"
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
