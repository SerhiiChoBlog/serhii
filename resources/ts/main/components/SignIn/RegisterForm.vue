<script setup lang="ts">
import SignInHeader from '@/components/SignIn/SignInHeader.vue'
import InputField from '@/components/Form/InputField.vue'
import FormLabel from '@/components/Form/FormLabel.vue'
import FormButton from '@/components/Form/FormButton.vue'
import Tip from '@shared/components/Tip.vue'
import SignInWith from '@/components/SignIn/SignInWith.vue'
import QuestionLink from '@/components/SignIn/QuestionLink.vue'
import useRegister from '@/composables/useRegister'

type Emits = {
    (e: 'changed'): void
}

const emit = defineEmits<Emits>()
const { loading, formData, errors, register } = useRegister()
</script>

<template>
    <sign-in-header
        headline="Register"
        sub-headline="Create an account to unlock extra features only for registered users"
    />

    <form @submit.prevent="register" class="space-y-5 my-6">
        <div>
            <form-label for="name" id="name">
                Name
                <tip :icon="true" content="The name is public and will be visible on your comments" />
            </form-label>
            <input-field
                name="name"
                id="name"
                type="text"
                placeholder="Enter your name"
                v-model="formData.name"
                :error-message="errors && errors.name ? errors.name[0] : null"
            />
        </div>

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
                id="register-password"
                type="password"
                placeholder="Enter your password"
                v-model="formData.password"
                :error-message="errors && errors.password ? errors.password[0] : null"
            />
        </div>

        <div class="pt-4">
            <form-button :loading="loading" type="submit">Register</form-button>
            <sign-in-with />
        </div>
    </form>

    <question-link
        question="Already have an account?"
        title="Sign in here"
        @clicked="emit('changed')"
    />
</template>
