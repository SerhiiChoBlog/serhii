<template>
    <Navbar :isLight="false" />

    <div class="container mt-6">
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="text" v-model="email" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" v-model="password" required />
            </div>
        </div>

        <div class="field">
            <button class="submit-button button is-info" @click="login">Submit</button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import Navbar from '@/components/Navbar.vue'
import { useStore } from 'vuex'

export default defineComponent({
    setup() {
        const email = ref<string>('')
        const password = ref<string>('')
        const store = useStore()

        function login() {
            store.dispatch('login', { email, password })
        }

        return {
            email,
            password,
            login,
        }
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