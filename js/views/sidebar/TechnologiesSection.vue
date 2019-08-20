<template>
    <ul class="collection with-header">
        <li class="collection-header center">
            <h4><i class="fas fa-wrench mr-2"></i> Used technologies</h4>
        </li>
        <li class="collection-item avatar" v-for="tech in techs" :key="tech.id">
            <img :src="`${iconUri}${tech.name}.png`" class="circle">
            <span class="title">{{ tech.name }}</span>
        </li>
    </ul>
</template>

<script>
export default {
    data() {
        return {
            iconUri: `${portfolio_globals.assets_uri}images/techs/`,
        }
    },

    props: ['techs'],
}
</script>

<style lang="sass" scoped>
.collection
    &-header h4 i
        color: #5b5b5b
        font-size: 14px

    &-item
        min-height: 60px !important
        text-align: left

        .title
            text-transform: capitalize
            line-height: 39px
</style>