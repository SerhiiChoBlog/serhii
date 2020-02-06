<template>
    <footer class="page-footer blue-grey darken-2">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <p class="grey-text text-lighten-4">
                        <span v-html="pageContent.content.substr(0, 200)+'...'"></span>
                        <a class="grey-text text-lighten-3" style="color:#a6e4e3!important;" href="javascript:" @click="$store.dispatch('showAboutMeModal')">
                            Read more...
                        </a>
                    </p>
                </div>

                <div class="col l4 offset-l2 s12">
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
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">Serhii Cho | Portfolio</div>
        </div>
    </footer>
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

<style>

</style>

