<template>

</template>

<script>
import { defineComponent } from 'vue'
import { useRoute } from 'vue-router'

export default defineComponent({
    setup() {
        const { params } = useRoute()
        console.log(params)
    },
})
</script>
