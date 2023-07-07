import { ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'

export default () => {
    const loading = ref<boolean>(false)

    function updateBookField(field: 'title' | 'rate' | 'read_at', value: string) {
        if (loading.value) {
            return
        }

        loading.value = true

        axios.put('/admin/ajax/books')
            .catch(handleError)
            .finally(() => loading.value = false)
    }

    return {
        updateBookField,
    }
}
