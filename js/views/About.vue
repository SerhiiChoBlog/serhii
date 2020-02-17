<template>
    <section class="about-section">
        <div class="container">
            <h1 v-html="pageContent.title" class="about-section__title"></h1>

            <div class="row">
                <div class="col m12 l4 mt-3">
                    <img src="/wp-content/themes/portfolio/assets/images/me.png" class="my-image z-depth-1" alt="My photo">
                    <Contacts></Contacts>
                </div>

                <div class="col m12 l8">
                    <div class="px-2">
                        <p v-html="pageContent.content"></p>
                    </div>
                </div>
            </div>
        </div>
        <Languages></Languages>
    </section>
</template>

<script>
import Languages from './inc/Languages'
import Contacts from './inc/Contacts'

export default {
    computed: {
        pageContent() {
            return this.$store.getters.getPageContent
        },
    },

    components: {
        Languages,
        Contacts,
    }
}
</script>

<style lang="sass" scoped>
.about-section
    table
        td
            padding: 7px 5px

    strong, b
        font-weight: bold !important

    .my-image
        width: 100%
        border-radius: 3px

@media(max-width: 600px)
    .about-section
        font-size: 1.1em
</style>