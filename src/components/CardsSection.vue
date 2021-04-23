<template>
    <section class="section is-medium" :class="{ 'bg-dark': bgDark }">
        <div class="container">
            <h2 class="is-size-3 has-text-centered mb-5">{{ header }}</h2>

            <div class="columns">
                <div class="column" v-for="tech in techs" :key="tech.title">
                    <div class="card is-shadowless" tech-card>
                        <div class="card-image">
                            <figure class="image is-4by3" tech-image>
                                <img
                                    :src="getToolsImages(tech.imageName)"
                                    :alt="tech.title"
                                />
                            </figure>
                        </div>
                        <div class="card-content has-text-centered">
                            <div class="title is-size-4">{{ tech.title }}</div>
                            <div class="content is-size-5">
                                {{ tech.content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue'
import { getToolsImages } from '@/modules/getImageUrl'
import CardSectionTech from '@/interfaces/CardSectionTech'

export default defineComponent({
    props: {
        techs: {
            type: Array as PropType<CardSectionTech[]>,
            required: true,
        },
        bgDark: Boolean,
        header: String,
    },

    setup() {
        return {
            getToolsImages,
        }
    },
})
</script>

<style lang="sass" scoped>
[tech-card]
    max-width: 400px
    margin: auto
    background-color: transparent

    [tech-image]
        text-align: center
        padding-top: 40%

        img
            width: 130px !important
            height: auto
            margin: auto

.bg-dark
    background-color: var(--grey-color)
</style>