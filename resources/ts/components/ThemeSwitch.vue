<template>
    <div class="flex items-center">
        <button class="relative inline-block p-1 bg-transparent text-yellow-500 dark:text-main hover:bg-gray-500 hover:bg-opacity-50 rounded-full"
            @click="switchTheme"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                width="27px"
                height="27px"
                viewBox="0 0 212.1 212.1"
                xml:space="preserve"
                fill="currentColor"
            >
                <!-- Sun -->
                <g class="origin-center transition-transform duration-500 rotate-[0turn] dark:rotate-[0.5turn]">
                    <path d="M181.1,75V31.1h-43.9L106.1,0L75,31.1H31.1V75L0,106.1l31.1,31.1v43.9H75l31.1,31.1l31.1-31.1h43.9v-43.9l31.1-31.1
                        L181.1,75z M106.1,162.1c-30.9,0-56-25.1-56-56s25.1-56,56-56s56,25.1,56,56S137,162.1,106.1,162.1z"
                    />
                </g>

                <!-- Circle -->
                <g class="origin-center transition-transform translate-x-0 dark:-translate-x-[15%]">
                    <circle cx="106.1" cy="106.1" r="41" />
                </g>
            </svg>
        </button>
    </div>
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
        },
    },

    setup({ theme }) {
        const currentTheme = ref<Theme>(theme)

        function switchTheme(): void {
            axios.get('/theme')
                .then((res) => {
                    if (currentTheme.value === 'light') {
                        currentTheme.value = 'dark'
                        document.body.classList.add('dark')
                    } else {
                        currentTheme.value = 'light'
                        document.body.classList.remove('dark')
                    }
                })
                .catch((err) => console.error(err))
        }

        return {
            switchTheme,
        }
    },
})
</script>
