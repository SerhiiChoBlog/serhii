import { ref } from 'vue'

export default () => {
    const loading = ref<boolean>(false)


    const redirectToReset = () => window.location.href = '/password/reset'

    return {
        loading,
        redirectToReset,
    }
}
