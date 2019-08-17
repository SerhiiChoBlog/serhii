<template>
    <nav>
        <div class="nav-wrapper px-5 white">
            <router-link to="/" class="left brand-logo black-text">Portfolio</router-link>
            <ul class="right" v-if="isAuth">
                <router-link to="/cabinet" tag="li" exact><a>Cabinet</a></router-link>
                <li><a @click="logOut">Exit</a></li>
            </ul>
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

</style>
