<template>
    <ul class="sidenav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="/wp-content/themes/portfolio/assets/images/me.jpg">
                </div>
                <a href="#user"><img class="circle" src="/wp-content/themes/portfolio/assets/images/me.jpg"></a>
                <a href="#name"><span class="white-text name">Serhii Cho</span></a>
                <a href="#email"><span class="white-text email">serhiicho@protonmail.com</span></a>
            </div>
        </li>

        <router-link tag="li" to="/about" class="center black-text" exact><a>About</a></router-link>
        <router-link tag="li" to="/" class="center black-text" exact><a>Portfolio</a></router-link>
    </ul>
</template>

<script>
export default {}
</script>

<style lang="sass" scoped>
.sidenav
    transform: translateX(0)
</style>