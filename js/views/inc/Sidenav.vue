<template>
    <ul class="sidenav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="/wp-content/themes/portfolio/assets/images/me3.png">
                </div>
                <a href="javascript:"><img class="circle" src="/wp-content/themes/portfolio/assets/images/me.jpg"></a>
                <a href="javascript:"><span class="white-text name">Serhii Cho</span></a>
                <a href="javascript:"><span class="white-text email">serhiicho@protonmail.com</span></a>
            </div>
        </li>

            <router-link tag="li" to="/" class="center black-text" exact><a>About</a></router-link>
            <router-link tag="li" to="/portfolio" class="center black-text" exact><a>Portfolio</a></router-link>
            <router-link tag="li" to="/contact" class="center black-text" exact><a>Contact</a></router-link>
    </ul>
</template>

<script>
export default {}
</script>

<style lang="sass" scoped>
.sidenav
    transform: translateX(0) !important
</style>