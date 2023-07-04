<script setup lang="ts">
import type { Book } from '@shared/types/models'
import type { Pagination } from '@shared/types/response'
import { onMounted, ref } from 'vue'
import handleError from '@admin/modules/handleError'
import axios from 'axios'
import PageTitle from '@admin/components/PageTitle.vue'
import IconButton from '@admin/components/Buttons/IconButton.vue'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'

const books = ref<Book[]>([])
const loading = ref<boolean>(true)

onMounted(() => fetchBooks())

function fetchBooks(): void {
    loading.value = true

    axios.get<Pagination<Book[]>>('/admin/ajax/books')
        .then(resp => books.value = resp.data.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container">
        <PageTitle>
            <div class="flex items-center justify-center gap-3">
                <span>Books</span>

                <MainButton type="button" :route="{ name: 'books-create' }" title="Create a new book">
                    <i class="fas fa-plus"></i>
                </MainButton>
            </div>
        </PageTitle>

        <div class="mt-5">
            <Spinner v-if="loading" />

            <h2 v-else-if="books.length === 0" class="text-center text-xl mt-6">
                There are not books yet
            </h2>

            <DataTable v-else>
                <template #head>
                    <HeadDetail
                        v-for="title in ['Image', 'Title', 'Author', 'Rate', 'Read at', 'Delete']"
                        :key="title"
                    >
                        {{ title }}
                    </HeadDetail>
                </template>

                <BodyRow v-for="book in books" :key="book.id">
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
                    <BodyDetail :style="{ color: book.rate_color }">
                        {{ book.rate }}
                    </BodyDetail>
                    <BodyDetail>
                        {{ book.read_at }}
                    </BodyDetail>
                    <BodyDetail class="max-w-[50px]">
                        <icon-button
                            icon="fa-trash"
                            title="Delete"
                            href="javascript:"
                        />
                    </BodyDetail>
                </BodyRow>
            </DataTable>
        </div>
    </div>
</template>
