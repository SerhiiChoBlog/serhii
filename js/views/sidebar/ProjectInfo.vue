<template>
    <ul class="collection">
        <li class="collection-item avatar" v-if="project.date">
            <i class="fas fa-calendar circle"></i>
            <span class="title">Project date</span>
            <p>{{ project.date }}</p>
        </li>
        <li class="collection-item avatar" v-if="project.client">
            <i class="fas fa-user-tie circle"></i>
            <span class="title">Client</span>
            <p>{{ project.client }}</p>
        </li>
        <li class="collection-item avatar" v-if="project.site">
            <i class="fas fa-link circle"></i>
            <span class="title">Site url</span>
            <p><a :href="project.site">{{ project.site }}</a></p>
        </li>
        <li class="collection-item avatar" v-if="project.github">
            <i class="fab fa-git circle"></i>
            <span class="title">Git repo</span>
            <p><a :href="project.github">{{ project.github }}</a></p>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        project: { required: true },
    },
}
</script>

<style lang="sass" scoped>

.collection-item
    min-height: 60px !important
    text-align: left

</style>