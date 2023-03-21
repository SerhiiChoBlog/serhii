<script setup lang="ts">
import SignInHeader from '@/components/SignIn/SignInHeader.vue'

type Emits = {
    (e: 'changed'): void
}

const emit = defineEmits<Emits>()
</script>

<template>
    <sign-in-header
        headline="Sign in"
        sub-headline="Sign in to your account to unlock some extra features only for registered users"
    />

    <span>
        New user?
        <button type="button" @click="emit('changed')">Register now</button>
    </span>
</template>
