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
        <BodyDetail class="text-lg">
            {{ book.title }}
        </BodyDetail>
        <BodyDetail>
            {{ book.author.name }}
        </BodyDetail>
        <BodyDetail>
            {{ book.rate }}
        </BodyDetail>
        <BodyDetail>
            {{ book.read_at }}
        </BodyDetail>
    </BodyRow>
</template>
