<script setup lang="ts">
import EyeIcon from '@shared/components/Icons/EyeIcon.vue'
import { ref } from 'vue'

type Props = {
    name: string
    address: string
}

const props = defineProps<Props>()
const show = ref<boolean>(false)
</script>

<template>
    <div class="flex gap-3 items-center">
        {{ name }}
        <code
            @click="show = true"
            :class="[
                'cursor-pointer wrap-anywhere text-sm w-full lg:text-lg',
                'bg-inline-code opacity-80 hover:opacity-100 transition-opacity',
                'rounded-sm flex gap-3 items-center px-2',
            ]"
        >
            <EyeIcon v-if="!show" />
            {{ show ? address : 'Click to reveal the address...' }}
        </code>
    </div>
</template>
