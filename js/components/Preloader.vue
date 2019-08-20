<template>
    <div :class="`preloader-wrapper active ${size}`">
        <div class="spinner-layer">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
            <div class="circle"></div>
        </div><div class="circle-clipper right">
            <div class="circle"></div>
        </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['size'],
}
</script>

<style lang="sass" scoped>
.spinner-layer
    border-color: #444
</style>
