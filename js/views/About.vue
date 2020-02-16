<template>
    <div class="about-me-page pt-3">
        <div class="container">
            <div class="row">
                <div class="col m12"><h1 v-html="pageContent.title" class="mb-2 mt-3"></h1></div>

                <div class="col m12 l4 mt-3">
                    <img src="/wp-content/themes/portfolio/assets/images/me.jpg" class="my-image z-depth-1" alt="My photo">
                </div>
                <div class="col m12 l8">
                    <p v-html="pageContent.content"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            pageContent() {
                return this.$store.getters.getPageContent
            },
        }
    }
</script>

<style lang="sass" scoped>
.about-me-page
    font-size: 1.3em
    min-height: 800px

    .my-image
        width: 90%
        border-radius: 3px

@media(max-width: 600px)
    .about-me-page
        font-size: 1.1em

</style>