<script setup lang="ts">
import Hamburger from '@/components/Navbar/Hamburger.vue'
import NavbarMenu from '@/components/Navbar/NavbarMenu.vue'
import { Theme } from '@shared/types'
import AppearTransition from '@shared/components/Transitions/AppearTransition.vue'

type Props = {
    theme: Theme
}

const { theme } = defineProps<Props>()
</script>

<template>
    <appear-transition>
        <nav class="relative z-20 print:hidden">
            <div class="container flex justify-between items-center min-h-[4rem]">
                <div class="flex items-center gap-x-1 w-full lg:w-auto">
                    <a
                        tabindex="1"
                        href="/"
                        class="print:hidden text-lg font-bold transition-opacity hover:opacity-80 text-lato drop-shadow-[1px_1px_0_rgba(0,0,0,.4)]"
                        aria-label="Visit main page"
                        rel="noreferrer"
                    >
                        <div class="tracking-wide">
                            <span class="text-white">serhii</span>
                            <span class="text-main-light">cho</span>
                        </div>
                    </a>

                    <hamburger />
                </div>

                <navbar-menu :theme="theme" />
            </div>
        </nav>
    </appear-transition>
</template>
