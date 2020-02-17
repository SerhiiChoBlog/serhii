<template>
    <section class="about-section">
        <div class="container">
            <h1 class="about-section__title">Primary languages</h1>

            <div class="row mt-2">
                <div class="col s12 l4" v-for="language in languagesInfo" :key="language.name">
                    <div class="card">
                        <div class="card-image">
                            <img :src="language.img">
                        </div>

                        <div class="card-content">
                            <span class="card-title">{{ language.name }}</span>
                            <p>{{ language.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import languages from '../../staticStore/languages'

export default {
    data() {
        return {
            languagesInfo: [],
        }
    },

    created() {
        this.languagesInfo = languages
    },
}
</script>

<style lang="sass" scoped>
.about-section
    background-color: white

    .card
        box-shadow: none
        background: transparent

        &-image
            text-align: center

            img
                max-width: 150px
                display: inline-block

        &-title
            text-align: center

        &-content
            text-align: left
            padding: 10px
</style>