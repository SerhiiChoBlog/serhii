<script setup lang="ts">
import MenuItems from '@shared/components/Dropdown/MenuItems.vue'
import MenuItem from '@shared/components/Dropdown/MenuItem.vue'
import { Menu, MenuButton } from '@headlessui/vue'
</script>

<template>
    <Menu>
        <menu-button>
            <slot />
        </menu-button>

        <menu-items>
            <menu-item>
                Logout
            </menu-item>
        </menu-items>
    </Menu>
</template>
