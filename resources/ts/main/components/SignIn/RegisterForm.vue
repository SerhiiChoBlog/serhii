<script setup lang="ts">
import SignInHeader from '@/components/SignIn/SignInHeader.vue'

type Emits = {
    (e: 'changed'): void
}

const emit = defineEmits<Emits>()
</script>

<template>
    <sign-in-header
        headline="Register"
        subHeadline="Create an account to unlock extra features only for registered users"
    />

    <span>
        Have an account?
        <button type="button" @click="emit('changed')">Login here</button>
    </span>
</template>
