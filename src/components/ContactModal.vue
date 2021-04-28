<template>
    <div class="button is-rounded is-info contact-me-button" @click="openContactModal">Contact me</div>

    <teleport to="#modals">
        <div class="modal is-active" v-show="isOpen">
            <div class="modal-background"></div>

            <transition name="animate-modal">
                <div class="modal-content" v-if="isOpen">
                    <div class="box">
                        <div class="content">
                            <h3 class="has-text-centered">Contact me</h3>
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
    display: flex
    justify-content: center
    align-items: center

    a
        opacity: .9
        margin-right: 25px
        animation: pulse 3s
        animation-iteration-count: infinite
        animation-direction: normal
        position: relative

        &:nth-child(2)
            animation-delay: 100ms

        &:nth-child(3)
            animation-delay: 200ms

        &:nth-child(4)
            animation-delay: 300ms

        &::before
            content: ""
            display: block
            width: 0
            height: 0
            background-color: blue
            border-radius: 50%
            position: absolute
            bottom: -4px
            left: 50%
            box-shadow: 0 0 3px 3px #3298dc
            opacity: 0
            transform: translateY(-15px)
            transition: transform 300ms, opacity 600ms

        &:hover
            &::before
                opacity: 1
                transform: translateY(0)

        img
            max-width: 35px

.animate-modal
    &-enter-active
        transition: transform 500ms cubic-bezier(1, 0.5, 0.8, 1), opacity 700ms

    &-enter-from
        opacity: 0
        transform: translateX(14px)

.modal
    .box
        margin: 10px
        padding: 30px
</style>