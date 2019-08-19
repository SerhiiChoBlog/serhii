<template>
    <nav>
        <div class="nav-wrapper px-5 white">
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

.brand-logo
    font-size: 1.5em
    text-transform: uppercase
    font-weight: bold

.nav-wrapper a
    color: #333

[button-back]
    opacity: .8
    transition: opacity 200ms
    animation-fill-mode: forwards
    animation: back-button-appear 500ms

    i
        font-size: 18px

    &:hover
        opacity: 1

</style>
