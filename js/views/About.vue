<template>
    <div class="about-me-page pt-3">
        <div class="container">
            <div class="row">
                <div class="col m12">
                    <h1 v-html="pageContent.title" class="mb-2 mt-3"></h1>
                </div>

                <div class="col m12 l4 mt-3">
                    <img src="/wp-content/themes/portfolio/assets/images/me.png" class="my-image z-depth-1" alt="My photo">

                    <table class="mt-2">
                        <tr v-for="info in contactInfo" :key="info.type">
                            <td><b>{{ info.type }}:</b></td>
                            <td>{{ info.value }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col m12 l8">
                    <div class="px-2">
                        <p v-html="pageContent.content"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import contact from '../store/contacts'

export default {
    data() {
        return {
            contactInfo: [],
        }
    },

    created() {
        this.contactInfo = contact
    },

    computed: {
        pageContent() {
            return this.$store.getters.getPageContent
        },
    }
}
</script>