<template>
    <div class="button is-rounded is-info contact-me-button" @click="openContactModal">Contact me</div>

    <teleport to="#modals">
        <div class="modal is-active" v-show="isOpen">
            <div class="modal-background"></div>

            <transition name="animate-modal">
                <div class="modal-content" v-if="isOpen">
                    <div class="box">
                        <div class="content">
                            <h3>Contact me</h3>
                            <p>
                                The fastest way to contact me is writing me an email at
                                <a href="mailto:serhiicho@protonmail.com" class="has-text-info">serhiicho@protonmail.com</a>
                            </p>

                            <div class="social-links mt-5">
                                <a href="https://github.com/SerhiiCho" target="_blank"><img src="@/assets/images/icons/github-dark.png" alt="github"></a>
                                <a href="https://www.linkedin.com/in/serhiicho" target="_blank"><img src="@/assets/images/icons/linkedin.png" alt="linked in"></a>
                                <a href="https://twitter.com/SerhiiCho" target="_blank"><img src="@/assets/images/icons/twitter.png" alt="twitter"></a>
                                <a href="https://www.instagram.com/serhiicho" target="_blank"><img src="@/assets/images/icons/instagram.png" alt="instagram"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>

            <button
                class="modal-close is-large"
                aria-label="close"
                @click="closeContactModal"
            ></button>
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
.social-links
    a
        opacity: .8
        transition: opacity 200ms
        margin-right: 20px

        &:hover
            opacity: 1

        img
            max-width: 40px

.animate-modal
    &-enter-active
        transition: transform 500ms cubic-bezier(1, 0.5, 0.8, 1), opacity 700ms

    &-enter-from
        opacity: 0
        transform: translateX(14px)
</style>