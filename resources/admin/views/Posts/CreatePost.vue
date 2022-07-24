<script setup lang="ts">
import MainButton from '../../components/Buttons/MainButton.vue'
import FormInput from '../../components/Form/FormInput.vue'

function createPost(): void {
    //
}
</script>

<template>
    <div class="container">
        <h1 class="text-3xl font-bold text-font-second">Basic information</h1>
        <h2 class="text-xl">Enter title for the future blog post.</h2>

        <form @submit.prevent="createPost" class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-[3fr_1fr] gap-5 max-w-3xl">
                <form-input
                    type="text"
                    placeholder="Enter the title"
                    :length="190"
                    id="title"
                >
                </form-input>

                <main-button>
                    <i class="fas fa-plus mr-2"></i>
                    <span>Create post</span>
                </main-button>
            </div>
        </form>
    </div>
</template>
