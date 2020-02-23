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
        <AboutSection :dark-bg="true" headline="Languages I'm using" :cards="languages"></AboutSection>
        <AboutSection :dark-bg="false" headline="Frameworks I've worked with" :cards="frameworks"></AboutSection>
    </section>
</template>

<script>
import AboutSection from './inc/AboutSection'
import Contacts from './inc/Contacts'
import languages from '../staticStore/languages'
import frameworks from '../staticStore/frameworks'

export default {
    data() {
        return {
            frameworks: [],
            languages: [],
        }
    },

    computed: {
        pageContent() {
            return this.$store.getters.getPageContent
        },
    },

    created() {
        this.languages = languages
        this.frameworks = frameworks
    },

    components: {
        AboutSection,
        Contacts,
    }
}
</script>

<style lang="sass" scoped>
.about-section
    table
        td
            padding: 7px 5px

    .my-image
        width: 100%
        border-radius: 3px

@media(max-width: 600px)
    .about-section
        font-size: 1.1em
</style>