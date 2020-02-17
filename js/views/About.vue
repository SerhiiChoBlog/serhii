<template>
    <div class="about-me-page pt-3">
        <div class="container">
            <div class="row">
                <div class="col m12">
                    <h1 v-html="pageContent.title" class="mb-2 mt-3"></h1>
                </div>

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
    </div>
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
.card
    //
</style>