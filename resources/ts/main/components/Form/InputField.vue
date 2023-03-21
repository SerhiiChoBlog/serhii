<script setup lang="ts">
import ShowPasswordButton from '@/components/ShowPasswordButton.vue'
import ValidationMessage from '@/components/Form/ValidationMessage.vue'

type Emits = {
    (e: 'changed', value: string): void
}

const emit = defineEmits<Emits>()

type Props = {
    name: string
    errorMessage?: string
    value?: string
    id?: string
    type?: 'text' | 'email' | 'password'
    placeholder?: string
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
    value: '',
    id: '',
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
            :value="props.value"
            :id="props.id"
            :ref="`ref-${props.name}`"
            @input="emit('changed', $event.target.value)"
        >

        <show-password-button
            v-if="props.type === 'password'"
            :input-id="props.id"
        />
    </div>

    <validation-message :message="props.errorMessage" />
</template>
