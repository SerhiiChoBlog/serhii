<template>
    <div>
        <nav>
            <div class="nav-wrapper px-5">
                <router-link to="/about" class="center brand-logo">Serhii Cho</router-link>

                <a href="javascript:" class="sidenav-trigger" @click="toggleModal">
                    <i class="fas fa-bars"></i>
                </a>

                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <router-link tag="li" to="/" class="center black-text" exact><a>About</a></router-link>
                    <router-link tag="li" to="/portfolio" class="center black-text" exact><a>Portfolio</a></router-link>
                    <router-link tag="li" to="/contact" class="center black-text" exact><a>Contact</a></router-link>
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

    a
        color: #333
</style>
