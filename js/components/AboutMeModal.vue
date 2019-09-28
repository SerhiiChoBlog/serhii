<template>
    <div>
        <div class="modal open" :style="showModal">
            <div class="modal-content">
                <div class="modal-top">
                    <h1 v-html="pageContent.title" class="m-0"></h1>
                    <img src="/wp-content/themes/portfolio/assets/images/me.jpg" class="my-image z-depth-1" alt="My photo">
                </div>
                <p v-html="pageContent.content"></p>
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

            pageContent() {
                return this.$store.getters.getPageContent
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
        max-height: 80%

        .my-image
            width: 65px
            border-radius: 50%

        .modal-top
            display: flex
            flex-direction: row
            align-items: center
            justify-content: space-between
            padding: 0 10px 10px 10px
            border-bottom: 1px solid #eae9e9

    .modal-overlay
        z-index: 1002
        display: block
        opacity: 0.5


    @media(max-width: 600px)
        .modal
            width: 95%
</style>
