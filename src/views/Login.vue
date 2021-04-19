<template>
    <Navbar :isLight="false" />

    <div class="container mt-6">
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="text" />
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" />
            </div>
        </div>

        <div class="field">
            <button class="submit-button button is-info">Submit</button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'

export default defineComponent({
    setup() {
        //
    },

    components: {
        Navbar,
    },
})
</script>

<style lang="sass" scoped>
.field
    max-width: 400px
    margin-right: auto
    margin-left: auto

    .submit-button
        width: 100%
        margin-top: 18px
</style>