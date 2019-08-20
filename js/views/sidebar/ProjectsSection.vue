<template>
    <ul class="collection with-header">
        <li class="collection-header center">
            <h4><i :class="`fas fa-${iconName} mr-2`"></i> {{ category }}</h4>
        </li>

        <router-link :to="`/project/${project.id}/`"
             v-for="project in filterProjectsByCategory(projects, category)"
             :key="project.id"
             v-html="project.title"
             tag="li"
             class="collection-item"
        ></router-link>
    </ul>
</template>

<script>
import filterProjectsByCategory from '../../modules/filterProjectsByCategory'

export default {
    props: ['category', 'iconName'],

    methods: {
        filterProjectsByCategory(projects, category) {
            return filterProjectsByCategory(projects, category)
        }
    },

    computed: {
        projects() {
            return this.$store.getters.getProjects
        },
    },
}
</script>

<style lang="sass" scoped>

.collection
    &-header h4 i
        color: #5b5b5b
        font-size: 14px

    &-item
        cursor: pointer
        color: #333
        transition: background-color 200ms

        &::first-letter
            font-weight: bold

        &:hover
            background-color: #f0f5ff

        &.active
            background-color: #e9f0ff
            color: #333

</style>