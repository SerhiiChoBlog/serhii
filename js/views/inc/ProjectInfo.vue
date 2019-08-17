<template>
    <ul class="collection">
        <li class="collection-item avatar">
            <i class="fas fa-calendar circle"></i>
            <span class="title">Project date</span>
            <p>{{ project.date }}</p>
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