import { ref } from 'vue'

export default () => {
    const isScrolledDown = ref<boolean>(window.scrollY > 50)

    document.addEventListener('scroll', () => {
        isScrolledDown.value = window.scrollY > 50
    })

    return {
        isScrolledDown,
    }
}
