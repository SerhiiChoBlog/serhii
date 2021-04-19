<template>
    <div class="modal" :class="{ 'is-active': isOpen }">
        <div class="modal-background"></div>

        <div class="modal-content">
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

        <button
            class="modal-close is-large"
            aria-label="close"
            @click="closeContactModal"
        ></button>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import useContactModal from '@/composables/useContactModal'

export default defineComponent({
    setup() {
        return { ...useContactModal() }
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
</style>