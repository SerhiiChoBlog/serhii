<script setup lang="ts">
import type { Theme } from '@shared/types'
import { ref } from 'vue'
import listenEvent from '@shared/modules/listenEvent'
import screenSizeIs from '@/modules/screenSizeIs'
import { events } from '@shared/appConfig'
import navLinks from '@/modules/navLinks'
import NavLink from '@/components/Navbar/NavLink.vue'
import ThemeSwitch from '@/components/Navbar/ThemeSwitch.vue'
import UserDropdown from '@/components/Navbar/UserDropdown.vue'
import SlideUpTransition from '@shared/components/Transitions/SlideUpTransition.vue'
import dispatchEvent from '@shared/modules/dispatchEvent'

type Props = {
    theme: Theme
}

const { theme } = defineProps<Props>()
const isActive = ref(!screenSizeIs(['sm', 'md', 'lg']))

listenEvent<boolean>(events.openMobileNavbar, isOpened => {
    isActive.value = isOpened
})

function closeMenu(): void {
    isActive.value = false
    dispatchEvent(events.openMobileNavbar, false)
}
</script>

<template>
    <div
        v-if="false"
        class="fixed inset-0 bg-black/70 z-10"
        @click="closeMenu"
    ></div>

    <slide-up-transition>
        <div
            v-if="isActive"
            class="flex flex-col lg:flex-row items-center gap-x-6 shadow-lg lg:shadow-none pb-7 lg:p-0 bg-[#363636] lg:bg-transparent absolute lg:static right-[20px] left-[20px] md:right-[120px] md:left-[120px] top-[77px] z-10 rounded-lg overflow-hidden lg:overflow-visible"
        >
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
    </slide-up-transition>
</template>
