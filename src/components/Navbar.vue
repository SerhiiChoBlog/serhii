<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <router-link to="/" class="navbar-item logo">
                    <b>SERHII<span class="has-text-info">CHO</span></b>
                </router-link>
                <span
                    class="navbar-burger"
                    id="burger-button"
                    @click="toggleMobileNavbar"
                >
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
            <div class="navbar-menu" id="nav-menu">
                <div class="navbar-end">
                    <router-link to="/" class="navbar-item">About</router-link>
                    <!-- <router-link to="/blog" class="navbar-item">Blog</router-link> -->
                    <router-link to="/projects" class="navbar-item"
                        >Open source</router-link
                    >
                    <div class="navbar-item">
                        <div
                            class="button is-rounded is-info contact-me-button"
                            @click="openContactModal"
                        >
                            Contact me
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <ContactModal @closeContactModalEvent="closeContactModal" />
</template>

<script lang="ts">
import { defineComponent, onMounted } from 'vue'
import ContactModal from '@/components/ContactModal.vue'

export default defineComponent({
    setup() {
        const openContactModal = () => {
            const elem = document.getElementById('contact-modal')!
            elem.classList.add('is-active')
        }

        const closeContactModal = () => {
            const elem = document.getElementById('contact-modal')!
            elem.classList.remove('is-active')
        }

        onMounted(() => {
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeContactModal()
                }
            })
        })

        const toggleMobileNavbar = () => {
            const burger = document.getElementById('burger-button')!
            const navMenu = document.getElementById('nav-menu')!

            if (burger.classList.contains('is-active')) {
                burger.classList.remove('is-active')
                navMenu.classList.remove('is-active')
            } else {
                burger.classList.add('is-active')
                navMenu.classList.add('is-active')
            }
        }

        return {
            openContactModal,
            closeContactModal,
            toggleMobileNavbar,
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
    color: #eee

    span
        width: 19px
        height: 2px

@media (max-width: 1041px)
    .navbar-menu
        position: absolute
        left: 20px
        right: 20px

    .contact-me-button
        width: 100%
</style>