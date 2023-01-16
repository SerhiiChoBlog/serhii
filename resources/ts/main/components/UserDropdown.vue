<script setup lang="ts">
import MenuItems from '@shared/components/Dropdown/MenuItems.vue'
import MenuItem from '@shared/components/Dropdown/MenuItem.vue'
import { Menu, MenuButton } from '@headlessui/vue'
import logout from '@shared/modules/logout'
</script>

<template>
    <Menu>
        <menu-button>
            <slot />
        </menu-button>

        <menu-items>
            <menu-item><a href="/user/profile">Profile</a></menu-item>
            <menu-item @click="logout">Logout</menu-item>
        </menu-items>
    </Menu>
</template>
