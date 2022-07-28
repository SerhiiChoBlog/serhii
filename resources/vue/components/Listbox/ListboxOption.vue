<script setup lang="ts">
import { ListboxOption } from '@headlessui/vue'</script>

<template>
    <listbox-option
        v-slot="{ active, selected }"
        as="template"
    >
        <li
            :class="[
                active ? 'bg-main-light text-black' : 'text-gray-900',
                'relative cursor-default select-none py-2 px-4 border-b border-border',
                selected ? 'bg-main-light' : ''
            ]"
        >
            <span class="block truncate">
                <slot />
            </span>
        </li>
    </listbox-option>

</template>
