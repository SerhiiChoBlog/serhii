<script setup lang="ts">
import useLogin from '@/composables/useLogin'
import SignInHeader from '@/components/SignIn/SignInHeader.vue'
import InputField from '@/components/Form/InputField.vue'
import FormLabel from '@/components/Form/FormLabel.vue'
import FormButton from '@/components/Form/FormButton.vue'
import Tip from '@shared/components/Tip.vue'
import SignInWith from '@/components/SignIn/SignInWith.vue'
import QuestionLink from '@/components/SignIn/QuestionLink.vue'

type Emits = {
    (e: 'changed'): void
}

const emit = defineEmits<Emits>()
const { loading, formData, errors, login, redirectToReset } = useLogin()
</script>

<template>
    <sign-in-header
        headline="Sign in"
        sub-headline="Welcome back! Please sign in to continue"
    />

    <form @submit.prevent="login" class="space-y-5 my-6">
        <div>
            <form-label for="email" id="email">
                Email
                <tip :icon="true" content="We never share email addresses with anyone else" />
            </form-label>
            <input-field
                name="email"
                id="login-email"
                type="email"
                placeholder="Enter your email"
                v-model="formData.email"
                :error-message="errors && errors.email ? errors.email[0] : null"
            />
        </div>

        <div>
            <form-label for="password" id="password">Password</form-label>
            <input-field
                name="password"
                id="login-password"
                type="password"
                placeholder="Enter your password"
                v-model="formData.password"
            />
        </div>

        <div class="pt-4">
            <form-button :loading="loading" type="submit">Sign in</form-button>
            <sign-in-with />
        </div>
    </form>

    <div class="flex items-center justify-center gap-9">
        <question-link
            question="Don't have an account?"
            title="Sign up"
            @clicked="emit('changed')"
        />

        <question-link
            question="Forgot your password?"
            title="Reset password"
            @clicked="redirectToReset"
        />
    </div>
</template>
