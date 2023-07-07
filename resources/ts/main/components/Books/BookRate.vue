<script setup lang="ts">
import StarIcon from '@shared/components/Icons/StarIcon.vue'

type Props = {
    rate: number
}

const { rate } = defineProps<Props>()
</script>

<template>
    <div class="flex">
        <star-icon
            v-for="r in rate"
            :key="r"
            class="w-5 h-5"
            style="color: darkorange"
            fill="darkorange"
        />

        <star-icon
            v-for="r in 5 - rate"
            :key="r"
            class="w-5 h-5 opacity-60"
            style="color: gray"
            fill="gray"
        />
    </div>
</template>