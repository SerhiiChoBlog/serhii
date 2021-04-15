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
import { computed, defineComponent } from 'vue'
import { useStore } from 'vuex'

export default defineComponent({
    setup() {
        const store = useStore()
        const isOpen = computed(() => store.state.isOpen)

        function closeContactModal(): void {
            store.commit('CLOSE_CONTACT_MODAL')
        }

        return { closeContactModal, isOpen }
    },
})
</script>