<template>
    <div class="modal" id="contact-modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <div class="content">
                    <h3>Contact me</h3>
                    <p>
                        The fastest way to contact me is writing me an email at
                        <a href="mailto:serhiicho@protonmail.com" class="has-text-info">serhiicho@protonmail.com</a>
                    </p>
                </div>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close" @click="closeContactModal"></button>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    setup(props, { emit }) {
        const closeContactModal = () => emit('closeContactModalEvent')
        return { closeContactModal }
    },
})
</script>