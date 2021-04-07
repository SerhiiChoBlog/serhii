<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <router-link logo to="/" class="navbar-item"><b>❤️ SERHII CHO</b></router-link>
                <span class="navbar-burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    <router-link to="/" class="navbar-item">About</router-link>
                    <router-link to="/blog" class="navbar-item">Blog</router-link>
                    <router-link to="/open-source" class="navbar-item">Open source</router-link>
                    <div class="navbar-item">
                        <router-link to="/contact" tag="div" class="button is-rounded is-info">Contact me</router-link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style lang="sass" scoped>
[logo]
    background-color: transparent !important
</style>