<script setup lang="ts">
import { computed } from 'vue'
import StarIcon from '@shared/components/Icons/StarIcon.vue'
import Tip from '@shared/components/Tip.vue'

type Props = {
    rate: number
}

const { rate } = defineProps<Props>()
const tipContent = computed(() => {
    let result = `Personal rate is ${rate}/5. `

    switch (rate) {
        case 5:
            result += 'An Excellent book. One of the best I have ever read.'
            break
        case 4:
            result += 'The book is good. I enjoyed it.'
            break
        case 3:
            result += 'The book is average. Not bad, but not good either.'
            break
        case 2:
            result += `I don't like the book. Poorly written.`
            break
        case 1:
            result += 'A terrible book. I regret reading it.'
            break
        default:
            return ''
    }

    return result
})
</script>

<template>
    <tip :content="tipContent">
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
    </tip>
</template>
