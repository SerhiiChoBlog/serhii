import { ref } from 'vue'

export default () => {
    const isScrolledDown = ref<boolean>(window.scrollY > 100)

    document.addEventListener('scroll', () => {
        isScrolledDown.value = window.scrollY > 100
    })

    return {
        isScrolledDown,
    }
}
