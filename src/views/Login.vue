<template>
    <Navbar :isLight="false" />

    <div class="container mt-6">
        <form @submit.prevent="login">
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
                <button type="submit" class="submit-button button is-info">Submit</button>
            </div>
        </form>
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
            store.dispatch('login', {
                email: email.value,
                password: password.value,
            })
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