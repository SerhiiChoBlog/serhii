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
                <button type="submit"
                    class="submit-button button is-info"
                    :class="{ 'is-loading': processingAuth }"
                >Submit</button>
            </div>
        </form>

        <div v-if="errorAuth" class="notification is-danger mt-5" @click="clearAuthError">
            <button class="delete"></button> {{ errorAuth }}
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'
import useLogin from '@/composables/auth/useLogin'

export default defineComponent({
    setup() {
        return {
            ...useLogin(),
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