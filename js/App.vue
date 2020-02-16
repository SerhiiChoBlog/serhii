<template>
    <div class="position-relative" @keydown.escape="$store.dispatch('hideAboutMeModal')">
        <Navbar></Navbar>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
import Navbar from './views/inc/Navbar'

export default {
    components: {
        Navbar,
    },
}
</script>

<style lang="sass">
@import './assets/animations'
@import './assets/bootstrap.scss'
@import './assets/language-logo'
@import './assets/common'
@import './assets/cards'

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
