<script setup lang="ts">
type Props = {
    id: string
    type: 'text' | 'email'
    placeholder: string
}

const { id, type, placeholder } = defineProps<Props>()
</script>

<template>
    <div class="flex flex-col max-w-sm">
        <label :for="id">
            <i class="text-red-500 mr-1.5">*</i>
            <slot />
        </label>

        <input
            :placeholder="placeholder"
            :type="type"
            :id="id"
            class="border rounded-md px-3 py-1"
        />
    </div>
</template>
