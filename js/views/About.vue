<template>
    <div class="container">
        <h1 v-html="pageContent.title" class="m-0"></h1>
        <img src="/wp-content/themes/portfolio/assets/images/me.jpg" class="my-image z-depth-1" alt="My photo">
        <p v-html="pageContent.content"></p>
        <ul>
            <li>
                <a class="grey-text text-lighten-3" href="https://github.com/SerhiiCho/" target="_blank">
                    <i class="fab fa-github mr-2"></i> 
                    Github
                </a>
            </li>
            <li>
                <a class="grey-text text-lighten-3" href="https://www.linkedin.com/in/serhiicho/" target="_blank">
                    <i class="fab fa-linkedin-in mr-2"></i> 
                    LinkedIn
                </a>
            </li>
            <li>
                <a class="grey-text text-lighten-3" href="https://twitter.com/SerhiiCho/" target="_blank">
                    <i class="fab fa-twitter mr-2"></i> 
                    Twitter
                </a>
            </li>
            <li>
                <a class="grey-text text-lighten-3" href="https://codesandbox.io/u/SerhiiCho/" target="_blank">
                    <i class="fas fa-code mr-2"></i>
                    Sandbox
                </a>
            </li>
        </ul>
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