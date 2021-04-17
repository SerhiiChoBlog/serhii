<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <router-link to="/" class="navbar-item logo">
                    <b>SERHII<span class="has-text-info">CHO</span></b>
                </router-link>

                <span class="navbar-burger" :class="{ 'burger-light': isLight }" id="burger-button" @click="toggleMobileNavbar">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
            <div class="navbar-menu" id="nav-menu">
                <div class="navbar-end">
                    <router-link to="/" class="navbar-item">About</router-link>
                    <!-- <router-link to="/blog" class="navbar-item">Blog</router-link> -->
                    <router-link to="/projects" class="navbar-item">Open source</router-link>
                    <div class="navbar-item">
                        <div class="button is-rounded is-info contact-me-button" @click="openContactModal">Contact me</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <ContactModal />
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import ContactModal from '@/components/ContactModal.vue'
import useContactModal from '@/composables/useContactModal'
import useNavbarHamburger from '@/composables/useNavbarHamburger'

export default defineComponent({
    props: {
        isLight: {
            type: Boolean,
            default: true,
            required: false,
        },
    },

    setup({ isLight }) {
        return {
            ...useNavbarHamburger(),
            ...useContactModal(),
            isLight,
        }
    },

    components: {
        ContactModal,
    },
})
</script>

<style lang="sass" scoped>
.logo
    background-color: transparent !important

.navbar-burger
    span
        width: 19px
        height: 2px

    &.burger-light
        color: #dfdede

@media (max-width: 1041px)
    .navbar-menu
        position: absolute
        left: 20px
        right: 20px

    .contact-me-button
        width: 100%
</style>