<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <router-link logo to="/" class="navbar-item">
                    <b>SERHII<span class="has-text-info">CHO</span></b>
                </router-link>
                <span class="navbar-burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    <router-link to="/" class="navbar-item">About</router-link>
                    <!-- <router-link to="/blog" class="navbar-item">Blog</router-link> -->
                    <router-link to="/open-source" class="navbar-item">Open source</router-link>
                    <div class="navbar-item">
                        <div class="button is-rounded is-info" @click="openContactModal">Contact me</div>
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
            window.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    closeContactModal()
                }
            })
        })

        return {
            openContactModal,
            closeContactModal,
        }
    },

    components: {
        ContactModal,
    },
})
</script>

<style lang="sass" scoped>
[logo]
    background-color: transparent !important
</style>