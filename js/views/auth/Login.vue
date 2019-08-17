<template>
    <div class="container mt-4">
        <div class="center mt-2 flow-text">Login</div>
        <div>
            <form>
                <div class="input-field" v-if="error">
                    <div class="alert">
                        <p v-text="error"></p>
                    </div>
                </div>
                <div class="input-field">
                    <input id="email" type="email" v-model="email">
                    <label for="email" class="active">Email</label>
                </div>
                <div class="input-field">
                    <input id="password" type="password" v-model="password">
                    <label for="password" class="active">Password</label>
                </div>
                <div class="input-field col s6">
                    <button class="btn" type="submit"
                        :disabled="processing"
                        @click.prevent="logIn"
                    >
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: null,
            password: null
        }
    },

    methods: {
        logIn() {
            this.$store.dispatch('logIn', {
                email: this.email,
                password: this.password
            })
        },
    },

    computed: {
        error() {
            return this.$store.getters.getError
        },

        processing() {
            return this.$store.getters.getProcessing
        },

        isAuth() {
            return this.$store.getters.isAuth
        },
    },

    watch: {
        isAuth(value) {
            if (value) this.$router.push('/cabinet')
        }
    },
}
</script>