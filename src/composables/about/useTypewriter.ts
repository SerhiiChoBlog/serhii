import { ref, onMounted } from 'vue'

export default () => {
    const typewriter = ref('')
    const words = ['software developer️ 😎', 'programmer 💻', 'full stack developer 💙']
    const wait = 3000
    let txt = ''
    let isDeleting = false
    let typeSpeed = 100
    let wordIndex = 0

    function init(): void {
        const current = wordIndex % words.length
        const fullTxt = words[current]

        if (isDeleting) {
            txt = fullTxt.substring(0, txt.length - 1)
        } else {
            txt = fullTxt.substring(0, txt.length + 1)
        }

        typewriter.value = txt

        if (isDeleting) {
            typeSpeed = 30
        }

        if (!isDeleting && txt === fullTxt) {
            typeSpeed = wait
            isDeleting = true
        } else if (isDeleting && txt === '') {
            typeSpeed = 100
            isDeleting = false
            wordIndex++
        }

        window.setTimeout(() => init(), typeSpeed)
    }

    onMounted(() => init())

    return { typewriter }
}