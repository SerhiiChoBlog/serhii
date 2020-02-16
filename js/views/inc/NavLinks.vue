<template>
    <ul>
        <router-link tag="li" to="/" class="black-text" exact><a>About</a></router-link>
        <router-link tag="li" to="/portfolio" class="black-text" exact><a>Portfolio</a></router-link>
    </ul>
</template>

<style lang="sass" scoped>
.black-text a
    color: #444

ul li a
    font-weight: bold
    font-size: 1.2em
    padding: 0 20px
    cursor: pointer

</style>