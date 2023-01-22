<script lang="ts" setup="">
import ExclamationCircle from '@shared/components/Icons/ExclamationCircle.vue'</script>

<template>
    <div class="flex items-center gap-2 bg-page-second border border-dotted border-border px-7 py-5 rounded-lg max-w-[800px] mx-auto opacity-90">
        <ExclamationCircle />

        <p class="text-lg">
            <slot />
        </p>
    </div>
</template>
