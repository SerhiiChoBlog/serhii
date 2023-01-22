<script setup lang="ts">
import MenuItems from '@shared/components/Dropdown/MenuItems.vue'
import MenuItem from '@shared/components/Dropdown/MenuItem.vue'
import { Menu, MenuButton } from '@headlessui/vue'
import logout from '@shared/modules/logout'

function redirectTo(url: string) {
    window.location.href = url
}
</script>

<template>
    <Menu v-if="Auth">
        <menu-button>
            <slot />
        </menu-button>

        <menu-items>
            <menu-item @click="redirectTo(`/user/${Auth!.slug}`)">Profile</menu-item>
            <menu-item @click="logout">Logout</menu-item>
        </menu-items>
    </Menu>
</template>
