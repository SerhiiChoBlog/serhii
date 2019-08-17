<template>
    <div class="pb-5">
        <Navbar></Navbar>
        <div class="container">
            <router-view></router-view>
        </div>
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

@import './assets/bootstrap.scss'
@import './assets/language-logo'
@import './assets/common'

</style>
