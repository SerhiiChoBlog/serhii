<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <router-link to="/" class="navbar-item logo">
                    <b>SERHII<span class="has-text-info">CHO</span></b>
                </router-link>

                <span class="navbar-burger" :class="{ 'burger-light': isLight, 'is-active': menuIsOpen }" @click="toggleMobileNavbar">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
            <div class="navbar-menu" :class="{ 'is-active': menuIsOpen }">
                <div class="navbar-end">
                    <router-link to="/" class="navbar-item has-stripe">About</router-link>
                    <router-link to="/projects" class="navbar-item has-stripe">Open source</router-link>
                    <router-link to="/posts" class="navbar-item has-stripe">Blog</router-link>
                    <div class="navbar-item"><ContactModal /></div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import ContactModal from '@/components/ContactModal.vue'
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
            isLight,
        }
    },

    components: {
        ContactModal,
    },
})
</script>

<style lang="sass" scoped>
.navbar
    .logo
        background-color: transparent !important

    .navbar-item
        position: relative

        &.has-stripe
            &::before
                content: ""
                height: 6px
                position: absolute
                left: 10px
                right: 10px
                bottom: 5px
                background-color: var(--main-color)
                opacity: 0
                transition: opacity 200ms
                border-radius: 8px

            &:hover,
            &.is-active
                &::before
                    opacity: 1

    .navbar-burger
        span
            width: 19px
            height: 2px

        &.burger-light
            color: #dfdede

@media (max-width: 1024px)
    .navbar-menu
        position: absolute
        left: 20px
        right: 20px
        padding: 0
        border-radius: 5px
        box-shadow: 2px 2px 9px -2px rgba(0, 0, 0, .5)

        .navbar-item
            padding: 20px 22px

            &.has-stripe
                &::before
                    content: none

                &:hover,
                &.is-active
                    background-color: rgba(0, 0, 0, .3) !important

    .contact-me-button
        width: 100%
</style>