<script setup lang="ts">
import MainButton from '@admin/components/Buttons/MainButton.vue'

//
</script>

<template>
    <div class="flex gap-3 items-center mt-7">
        <MainButton>
            <i class="fas fa-plus mr-2"></i>
            Add post
        </MainButton>

        <input
            type="text"
            placeholder="Post slug"
            class="px-5 py-2 rounded-md bg-page-second w-full max-w-[400px]"
        />

        <button type="button">
            <i class="fas fa-paste text-2xl"></i>
        </button>
    </div>
</template>
