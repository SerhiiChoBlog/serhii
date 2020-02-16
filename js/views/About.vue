<template>
    <div class="container pt-3" style="min-height:800px">
        <h1 v-html="pageContent.title" class="m-0"></h1>
        <img src="/wp-content/themes/portfolio/assets/images/me.jpg" class="my-image z-depth-1" alt="My photo">
        <p v-html="pageContent.content"></p>
    </div>
</template>

<script>
    export default {
        computed: {
            pageContent() {
                return this.$store.getters.getPageContent
            },
        }
    }
</script>