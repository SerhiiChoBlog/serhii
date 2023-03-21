<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import AppearTransition from '@shared/components/Transitions/AppearTransition.vue'
import CloseIcon from '@shared/components/Icons/CloseIcon.vue'

type Props = {
    opened: boolean
    maxWidth?: string
}

type Emits = {
    (e: 'close'): void
}

const emit = defineEmits<Emits>()
const props = defineProps<Props>()
const isOpen = ref<boolean>(props.opened)

watch(props, (props: Props) => {
    isOpen.value = props.opened
})

onMounted(() => {
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            emit('close')
        }
    })
})
</script>

<template>
    <appear-transition>
        <aside v-show="isOpen" class="fixed inset-0 z-40 bg-black/80">
            <div
                v-if="isOpen"
                class="overflow-y-auto absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[1000px] mx-auto max-h-[calc(100vh-40px)]"
                :style="{ maxWidth: props.maxWidth + 'px' }"
            >
                <div class="bg-page text-font shadow-xl rounded-lg p-10 h-full relative">
                    <button
                        @click="emit('close')"
                        type="button"
                        class="absolute top-2 right-2 p-3 text-font-second hover:text-red-600 transition-colors"
                        aria-label="Close contacts modal button"
                    >
                        <close-icon class="w-6 h-6" />
                    </button>

                    <slot />
                </div>
            </div>
        </aside>
    </appear-transition>
</template>
