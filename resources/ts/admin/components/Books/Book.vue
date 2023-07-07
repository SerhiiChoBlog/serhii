<script setup lang="ts">
import type { Book } from '@shared/types/models'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'

type Props = {
    book: Book
}

const { book } = defineProps<Props>()
</script>

<template>
    <BodyRow>
        <BodyDetail class="w-28">
            <img
                :src="`/storage/books/${book.image}`"
                :alt="`Logo of ${book.name}`"
                width="378"
                height="300"
                class="h-20 w-auto rounded-sm"
            />
        </BodyDetail>
        <BodyDetail>
            <input
                type="text"
                :value="book.title"
                class="w-full bg-transparent border-none py-1 px-2 text-lg"
            />
        </BodyDetail>
        <BodyDetail>
            {{ book.author.name }}
        </BodyDetail>
        <BodyDetail>
            <input
                type="number"
                min="1"
                max="5"
                :value="book.rate"
                class="w-14 bg-transparent border-none text-center p-1"
            />
        </BodyDetail>
        <BodyDetail>
            {{ book.read_at }}
        </BodyDetail>
    </BodyRow>
</template>
