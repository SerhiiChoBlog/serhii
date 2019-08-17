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
};
</script>

<style lang="scss">
@import './assets/bootstrap';
@import './assets/language-logo.sass';
</style>
