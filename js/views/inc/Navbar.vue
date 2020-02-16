<template>
    <div>
        <nav>
            <div class="nav-wrapper px-5">
                <router-link to="/about" class="center brand-logo">Serhii Cho</router-link>

                <a href="javascript:" class="sidenav-trigger" @click="showSidebar = !showSidebar">
                    <i class="fas fa-bars"></i>
                </a>

                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <router-link tag="li" to="/about" class="center black-text" exact><a>About</a></router-link>
                    <router-link tag="li" to="/" class="center black-text" exact><a>Portfolio</a></router-link>
                </ul>
            </div>
        </nav>

        <transition name="fade" mode="out-in">
            <div v-if="showSidebar">
                <div class="sidenav-overlay" @click="showSidebar = !showSidebar"></div>
            </div>
        </transition>

        <transition name="fade" mode="out-in">
            <div v-if="showSidebar">
                <ul class="sidenav">
                    <router-link tag="li" to="/about" class="center black-text" exact><a>About</a></router-link>
                    <router-link tag="li" to="/" class="center black-text" exact><a>Portfolio</a></router-link>
                </ul>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showSidebar: false,
        }
    }
}
</script>

<style lang="sass" scoped>
.sidenav
    transform: translateX(0)

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
