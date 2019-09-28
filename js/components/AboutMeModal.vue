<template>
    <div>
        <div class="modal open" :style="showModal">
            <div class="modal-content">
                <h4>Modal Header</h4>
                <p>A bunch of text</p>
            </div>
        </div>
        <div class="modal-overlay" :style="showModal" @click="$store.dispatch('hideAboutMeModal')"><div></div></div>
    </div>
</template>

<script>
    export default {
        computed: {
            showModal() {
                return this.$store.getters.isVisibleModal ? null : 'display:none'
            },
        }
    }
</script>

<style lang="sass" scoped>
    .modal
        z-index: 1003
        display: block
        opacity: 1
        top: 50%
        left: 50%
        transform: translate(-50%, -50%)

    .modal-overlay
        z-index: 1002
        display: block
        opacity: 0.5


    @media(max-width: 600px)
        .modal
            width: 95%
</style>
