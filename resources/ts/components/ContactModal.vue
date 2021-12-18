<template>
    <div class="button is-rounded is-info contact-me-button" @click="openContactModal">Contact me</div>

    <teleport to="#modals">
        <div class="modal is-active" v-show="isOpen">
            <div class="modal-background"></div>

            <transition name="fade">
                <div class="modal-content" v-if="isOpen">
                    <div class="box">
                        <div class="content">
                            <h3 class="has-text-centered">Contact me</h3>
                            <p>
                                The fastest way to contact me is to send me an email at
                                <a
                                    href="mailto:serhiicho@protonmail.com"
                                    class="has-text-info"
                                >serhiicho@protonmail.com</a> or text me on Linkedin.
                            </p>

                            <div class="social-links mt-5">
                                <a href="https://www.linkedin.com/in/serhiicho" target="_blank" title="LinkedIn">
                                    <img src="/storage/icons/linkedin.png" alt="linked in" />
                                </a>
                                <a href="https://github.com/SerhiiCho" target="_blank" title="GitHub">
                                    <img src="/storage/icons/github-dark.png" alt="github" />
                                </a>
                                <a href="https://laracasts.com/@SerhiiCho" target="_blank" title="Laracasts">
                                    <img src="/storage/icons/laracasts.png" alt="laracasts" />
                                </a>
                                <a href="https://www.codewars.com/users/serhii_cho" target="_blank" title="Codewars">
                                    <img src="/storage/icons/codewars.png" alt="Codewars" />
                                </a>
                                <a href="https://www.instagram.com/serhiicho" target="_blank" title="Instagram">
                                    <img src="/storage/icons/instagram.png" alt="instagram" />
                                </a>
                                <a href="https://twitter.com/SerhiiCho" target="_blank" title="Twitter">
                                    <img src="/storage/icons/twitter.png" alt="twitter" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>

            <button class="modal-close is-large" aria-label="close" @click="closeContactModal"></button>
        </div>
    </teleport>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'

export default defineComponent({
    setup() {
        const isOpen = ref(false)

        function openContactModal(): void {
            isOpen.value = true
        }

        function closeContactModal(): void {
            isOpen.value = false
        }

        window.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeContactModal()
            }
        })

        return { isOpen, openContactModal, closeContactModal }
    },
})
</script>

<style lang="sass" scoped>
.modal
    .box
        margin: 10px
        padding: 30px
</style>
