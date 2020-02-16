<template>
    <div>
        <nav>
            <div class="nav-wrapper px-5">
                <a href="javascript:" class="sidenav-trigger" @click="toggleModal">
                    <i class="fas fa-bars"></i>
                </a>

                <router-link to="/about" class="center brand-logo">Serhii Cho</router-link>

                <ul class="hide-on-med-and-down center">
                    <router-link tag="li" to="/" class="black-text" exact><a>About</a></router-link>
                    <router-link tag="li" to="/portfolio" class="black-text" exact><a>Portfolio</a></router-link>
                </ul>

                <ul class="hide-on-med-and-down right">
                    <li>
                        <a class="grey-text text-darken-2" href="https://github.com/SerhiiCho/" target="_blank">
                            <i class="fab fa-github"></i>
                        </a>
                    </li>
                    <li>
                        <a class="grey-text text-darken-2" href="https://www.linkedin.com/in/serhiicho/" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                    <li>
                        <a class="grey-text text-darken-2" href="https://twitter.com/SerhiiCho/" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <transition name="fade" mode="out-in">
            <div v-if="showSidebar">
                <div class="sidenav-overlay" @click="toggleModal"></div>
            </div>
        </transition>

        <transition name="fade" mode="out-in">
            <div v-if="showSidebar"><Sidenav></Sidenav></div>
        </transition>
    </div>
</template>

<script>
import Sidenav from '../inc/Sidenav'

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
    }
}
</script>

<style lang="sass" scoped>
.sidenav-overlay
    display: block
    opacity: 1

nav
    box-shadow: none
    background-color: #eee

.brand-logo
    font-size: 1.5em
    text-transform: uppercase
    font-weight: bold

.nav-wrapper
    background-color: #f9f9f9
    box-shadow: 2px 2px 10px rgba(0,0,0,.07)
    overflow: hidden

    a
        color: #333
</style>
