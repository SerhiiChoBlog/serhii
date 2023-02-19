<script setup lang="ts">
import type { Theme } from '@shared/types'
import navLinks from '@/modules/navLinks'
import NavLink from '@/components/Navbar/NavLink.vue'
import ThemeSwitch from '@/components/Navbar/ThemeSwitch.vue'
import UserDropdown from '@/components/Navbar/UserDropdown.vue'

type Props = {
    theme: Theme
}

const { theme } = defineProps<Props>()
</script>

<template>
    <div class="navbar-menu pb-8 lg:pb-0" id="navbar-menu">
        <nav-link
            v-for="item in navLinks"
            :key="item.href"
            :href="item.href"
            :classes="item.class"
        >
            {{ item.title }}
        </nav-link>

        <div class="min-w-[35px] mx-auto mt-5 lg:mt-0">
            <theme-switch :theme="theme" />
        </div>

        <div class="mx-auto lg:m-0 text-center mt-5 relative">
            <user-dropdown v-if="Auth">
                <button
                    type="button"
                    class="flex items-center justify-center gap-4 bg-black/20 rounded-full pl-5 hover:bg-black/40 transition-colors group"
                >
                    <div class="overflow-hidden overflow-ellipsis whitespace-nowrap max-w-[150px] text-lg">
                        {{ Auth.name }}
                    </div>

                    <img
                        :src="`/storage/avatars/${Auth.avatar}`"
                        alt="Profile picture"
                        width="200"
                        height="200"
                        class="rounded-full w-10 h-10 shadow-md group-hover:shadow-lg"
                    />
                </button>
            </user-dropdown>

            <a
                v-else
                href="/login"
                class="main-btn min-w-[140px]"
                rel="noreferrer"
            >
                Login
            </a>
        </div>
    </div>
</template>
