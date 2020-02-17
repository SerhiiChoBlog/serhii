<template>
    <ul class="sidenav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="/wp-content/themes/portfolio/assets/images/me3.png">
                </div>
                <a><span class="white-text name">Serhii Cho</span></a>
                <a><span class="white-text email">serhiicho@protonmail.com</span></a>
            </div>
        </li>
        <NavLinks></NavLinks>
    </ul>
</template>

<script>
import NavLinks from './NavLinks'

export default {
    components: {
        NavLinks
    }
}
</script>

<style lang="sass" scoped>
</style>