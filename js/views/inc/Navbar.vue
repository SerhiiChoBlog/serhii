<template>
    <nav>
        <div class="nav-wrapper px-5">
            <router-link to="/" button-back v-if="$route.name == 'single'">
                <i class="fas fa-chevron-left"></i>
            </router-link>
            <router-link to="/" class="center brand-logo black-text">Portfolio</router-link>
        </div>
    </nav>
</template>

<script>
export default {
    computed: {
        isAuth() {
            return this.$store.getters.isAuth
        }, 
    },

    methods: {
        logOut() {
            if (confirm('Are you sure to logout?')) {
                this.$store.dispatch('logOut')
                this.$router.push('/login')
            }
        },
    },
}
</script>

<style lang="sass" scoped>

nav
    box-shadow: none
    background-color: #eee
    height: 74px
    line-height: 74px

.brand-logo
    font-size: 1.5em
    text-transform: uppercase
    font-weight: bold

.nav-wrapper
    background-color: #f9f9f9
    box-shadow: 2px 2px 10px rgba(0,0,0,.07)
    transform: rotate(-.4deg) translateY(-5px)

    a
        color: #333

[button-back]
    opacity: .8
    transition: opacity 200ms
    animation-fill-mode: forwards
    animation: back-button-appear 500ms
    transform: scaleX(1.9)
    display: inline-block

    i
        font-size: 14px

    &:hover
        opacity: 1

</style>
