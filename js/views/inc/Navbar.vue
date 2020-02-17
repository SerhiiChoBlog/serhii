<template>
    <div>
        <nav>
            <div class="nav-wrapper">
                <div class="container">
                    <a href="javascript:" class="sidenav-trigger" @click="toggleModal">
                        <i class="fas fa-bars"></i>
                    </a>

                    <router-link to="/" class="center brand-logo">Serhii Cho</router-link>

                    <div class="hide-on-med-and-down center"><NavLinks></NavLinks></div>

                    <ul class="hide-on-med-and-down right">
                        <li>
                            <a href="https://github.com/SerhiiCho/" target="_blank">
                                <i class="fab fa-github"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/in/serhiicho/" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/SerhiiCho/" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div v-if="showSidebar">
            <div class="sidenav-overlay" @click="toggleModal"></div>
        </div>

        <div v-if="showSidebar"><Sidenav></Sidenav></div>
    </div>
</template>

<script>
import Sidenav from '../inc/Sidenav'
import NavLinks from '../inc/NavLinks'

export default {
    data() {
        return {
            showSidebar: false,
        }
    },

    created() {
        Event.$on('new-view', () => this.showSidebar = false)
    },

    methods: {
        toggleModal() {
            this.showSidebar = !this.showSidebar
        }
    },

    components: {
        Sidenav,
        NavLinks,
    }
}
</script>

<style lang="sass" scoped>
nav
    box-shadow: none
    background-color: #eee

    ul li a i
        color: #444
        font-size: 1.3em
    
    .sidenav-trigger
        color: #444

.brand-logo
    font-size: 1.5em
    font-weight: bold
    color: #333

.nav-wrapper
    background-color: #f9f9f9
    box-shadow: 2px 2px 10px rgba(0,0,0,.07)
    overflow: hidden
</style>
