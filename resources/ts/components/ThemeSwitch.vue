<template>
    <h2 @click="switchTheme">here</h2>
</template>

<script lang="ts">
import { defineComponent, PropType, ref } from 'vue'
import axios from 'axios'

type Theme = 'light' | 'dark'

export default defineComponent({
    props: {
        theme: {
            type: String as PropType<Theme>,
            required: true,
        }
    },

    setup({ theme }) {
        const currentTheme = ref<Theme>(theme)

        function switchTheme(): void {
            axios.get('/theme')
                .then(res => {
                    if (currentTheme.value === 'light') {
                        currentTheme.value = 'dark'
                        document.body.classList.add('dark-theme')
                    } else {
                        currentTheme.value = 'light'
                        document.body.classList.remove('dark-theme')
                    }
                })
                .catch(err => console.error(err))
        }

        return {
            switchTheme,
            currentTheme,
        }
    },
})
</script>
