<script setup lang="ts">
import SignInHeader from '@/components/SignIn/SignInHeader.vue'
import InputField from '@/components/Form/InputField.vue'
import FormLabel from '@/components/Form/FormLabel.vue'

type Emits = {
    (e: 'changed'): void
}

const emit = defineEmits<Emits>()
</script>

<template>
    <sign-in-header
        headline="Register"
        sub-headline="Create an account to unlock extra features only for registered users"
    />

    <form class="space-y-5 my-6">
        <div>
            <form-label for="email" id="email">Email</form-label>
            <input-field
                name="email"
                id="email"
                type="email"
                placeholder="Enter your email"
            />
        </div>
    </form>

    <span>
        Have an account?
        <button type="button" @click="emit('changed')">Login here</button>
    </span>
</template>
