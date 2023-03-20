<script setup lang="ts">
import { ref } from 'vue'
import Modal from '@/components/Modal.vue'
import RegisterForm from '@/components/SignIn/RegisterForm.vue'
import LoginForm from '@/components/SignIn/LoginForm.vue'

const isOpen = ref<boolean>(true)
const showRegisterForm = ref<boolean>(true)
</script>

<template>
    <modal :opened="isOpen" @close="isOpen = false">
        <register-form v-if="showRegisterForm" @changed="showRegisterForm = false" />
        <login-form v-else @changed="showRegisterForm = true" />
    </modal>
</template>
