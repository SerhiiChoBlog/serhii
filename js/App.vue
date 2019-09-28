<template>
    <div class="position-relative" @keydown.escape="$store.dispatch('hideAboutMeModal')">
        <Navbar></Navbar>
        <div class="container">
            <transition name="fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>
        <Footer></Footer>

        <a href="javascript:" class="about-me-button" @click="$store.dispatch('showAboutMeModal')">About me</a>
        <AboutMeModal></AboutMeModal>
    </div>
</template>

<script>
import Navbar from './views/inc/Navbar'
import Footer from './views/inc/Footer'
import AboutMeModal from './components/AboutMeModal'

export default {
    components: {
        Navbar,
        Footer,
        AboutMeModal,
    },
}
</script>

<style lang="sass">
@import './assets/animations'
@import './assets/bootstrap.scss'
@import './assets/language-logo'
@import './assets/common'
@import './assets/cards'
@import './assets/about'

.fade
    &-enter-active,
    &-leave-active
        transition-duration: 0.1s
        transition-property: opacity
        transition-timing-function: ease

    &-enter,
    &-leave-active
        opacity: 0
</style>
