<script setup lang="ts">
import { MenuItem } from '@headlessui/vue'
</script>

<template>
    <menu-item v-slot="{ active }">
        <button :class="[
            active ? 'bg-main text-white' : 'text-gray-900',
            'group flex w-full items-center rounded-md px-3 py-2 text-sm',
        ]">
            <slot />
        </button>
    </menu-item>
</template>
