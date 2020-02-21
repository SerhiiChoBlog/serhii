<template>
    <section class="about-section" :class="{ 'dark-bg': darkBg }">
        <div class="container">
            <h1 class="about-section__title">{{ headline }}</h1>

            <div class="row mt-2">
                <div class="col s12 l4" v-for="card in cards" :key="card.name">
                    <div class="card">
                        <div class="card-image">
                            <img :src="card.img">
                        </div>

                        <div class="card-content">
                            <span class="card-title">{{ card.name }}</span>
                            <p>{{ card.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: ['cards', 'headline', 'darkBg'],
}
</script>

<style lang="sass" scoped>
.about-section
    .dark-bg
        background-color: #f0f0f0

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