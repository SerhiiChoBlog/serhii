import { onMounted } from 'vue'
import { getUpdatePageViewsUrl } from '@/config'
import { useRoute } from 'vue-router'

export default () => {
    const route = useRoute()

    onMounted(() => {
        fetch(getUpdatePageViewsUrl(), {
            method: 'POST',
            body: JSON.stringify({ slug: route.params.projectName }),
            headers: { 'Content-Type': 'application/json' },
        })
            .catch(err => console.error(err))
    })
}