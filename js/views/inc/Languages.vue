<template>
    <div component>
        <div class="container">
            <div class="row">
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
    </div>
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
[component]
    background-color: white
    padding: 50px 5px

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
</style>