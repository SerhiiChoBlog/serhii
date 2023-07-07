<script setup lang="ts">
import type { Book } from '@shared/types/models'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'

type Props = {
    book: Book
}

type Emits = {
    (e: 'title-changed', v: string): void
    (e: 'rate-changed', v: string): void
    (e: 'read-at-changed', v: string): void
}

const emit = defineEmits<Emits>()
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
                @blur="e => emit('title-changed', e.target.value)"
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
                @blur="e => emit('rate-changed', e.target.value)"
            />
        </BodyDetail>
        <BodyDetail>
            <input
                type="date"
                :value="book.read_at"
                class="bg-transparent border-none py-1 px-3"
                pattern="\d{4}-\d{2}-\d{2}"
                @blur="e => emit('read-at-changed', e.target.value)"
            />
        </BodyDetail>
    </BodyRow>
</template>
