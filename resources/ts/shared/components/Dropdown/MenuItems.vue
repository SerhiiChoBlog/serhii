<script setup lang="ts">
import { MenuItems } from '@headlessui/vue'
import DropdownTransition from '@shared/components/Transitions/DropdownTransition.vue'
</script>

<template>
    <dropdown-transition>
        <menu-items class="absolute right-0 mt-12 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
            <slot />
        </menu-items>
    </dropdown-transition>
</template>
