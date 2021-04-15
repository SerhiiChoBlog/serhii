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