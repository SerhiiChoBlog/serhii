<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <router-link to="/" class="navbar-item" style="background: transparent !important">
                    <b>SERHII CHO</b>
                </router-link>
                <span class="navbar-burger" data-target="navbarMenuHeroB">
            <span></span>
            <span></span>
            <span></span>
          </span>
            </div>
            <div id="navbarMenuHeroB" class="navbar-menu">
                <div class="navbar-end">
                    <router-link to="/" class="navbar-item" exact>Home</router-link>
                    <router-link to="/blog" class="navbar-item" exact>Blog</router-link>
                    <router-link to="/open-source" class="navbar-item" exact>Open source</router-link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    data() {
        return {
            //
        }
    },
})
</script>
