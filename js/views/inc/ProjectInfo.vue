<template>
    <ul class="collection">
        <li class="collection-item avatar">
            <i class="fas fa-calendar circle"></i>
            <span class="title">Project date</span>
            <p>{{ project.date }}</p>
        </li>
        <li class="collection-item avatar">
            <i class="fas fa-user-tie circle"></i>
            <span class="title">Client</span>
            <p>{{ project.client }}</p>
        </li>
        <li class="collection-item avatar">
            <i class="fas fa-link circle"></i>
            <span class="title">Site url</span>
            <p><a :href="project.siteUrl">{{ project.siteUrl }}</a></p>
        </li>
        <li class="collection-item avatar">
            <i class="fab fa-git circle"></i>
            <span class="title">Git repo</span>
            <p><a :href="project.gitRepo">{{ project.gitRepo }}</a></p>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        project: { required: true, }
    },
}
</script>

<style lang="sass" scoped>

.collection
    border: none

    &-item
        min-height: 60px !important
        background-color: transparent
        border: none
        text-align: left

</style>