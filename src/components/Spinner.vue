<template>
    <svg class="spinner" viewBox="0 0 50 50">
        <circle
            class="path"
            cx="25"
            cy="25"
            r="20"
            fill="none"
            stroke-width="5"
        ></circle>
    </svg>
</template>

<style lang="sass" scoped>
.spinner
    animation: rotate 2s linear infinite
    z-index: 2
    top: 50%
    left: 50%
    margin: auto
    width: 55px
    height: 55px

    & .path
        stroke: #3298dc
        stroke-linecap: round
        animation: dash 1.3s ease-in-out infinite

@keyframes rotate
    100%
        transform: rotate(360deg)

@keyframes dash
    0%
        stroke-dasharray: 1, 150
        stroke-dashoffset: 0
    50%
        stroke-dasharray: 90, 150
        stroke-dashoffset: -35
    100%
        stroke-dasharray: 90, 150
        stroke-dashoffset: -124
</style>