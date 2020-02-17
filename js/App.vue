<template>
    <div class="position-relative" @keydown.escape="$store.dispatch('hideAboutMeModal')">
        <Navbar></Navbar>
        <vue-page-transition name="fade-in-left">
            <router-view></router-view>
        </vue-page-transition>
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
</style>
