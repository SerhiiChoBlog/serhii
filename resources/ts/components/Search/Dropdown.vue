<script setup lang="ts">
import { Search } from '../../types/types'

interface Props {
    search: Search
}

const { search } = defineProps<Props>()
</script>

<template>
    <div class="bg-white shadow-xl p-6 top-[45px] lg:top-[calc(100%+5px)] border-t bg-white absolute left-0 right-0 z-50 lg:rounded-3xl rounded-none">
        <history v-if="search.history.length > 0" :history="search.history" />

        <div v-else>
            <not-found v-if="search.services.length === 0 && search.specialists.length === 0" />

            <div v-else>
                <div class="flex justify-between relative after:content-'' after:w-[1px] after:absolute after:h-full after:top-0 after:bg-red-500 after:left-1/2 after:bg-border">
                    <dropdown-items-section
                        :heading="$trans.get('common.specialists')"
                        :items="search.specialists"
                        class="pr-2"
                        link-url="/specialists/{id}"
                    />

                    <dropdown-items-section
                       :heading="$trans.get('common.services')"
                       :items="search.services"
                       class="pl-2"
                       link-url="/services/{id}"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
