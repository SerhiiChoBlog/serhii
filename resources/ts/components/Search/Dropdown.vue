<script setup lang="ts">
import { Search } from '../../types/types'

interface Props {
    search: Search
}

const { search } = defineProps<Props>()
</script>

<template>
    <div class="bg-white rounded-3xl p-5 absolute left-1/2 -translate-x-1/2 top-full mt-3 w-full">
        nice
    </div>
</template>
