import { ref, onMounted } from 'vue'

export default () => {
    const typewriter = ref('')
    const words = ['software developer️ 😎', 'programmer 💻', 'full stack developer 💙']
    const wait = 3000
    let text = ''
    let isDeleting = false
    let typingSpeed = 100
    let wordIndex = 0

    function initTypewriter(): void {
        const current = wordIndex % words.length
        const fullText = words[current]

        text = isDeleting
            ? fullText.substring(0, text.length - 1)
            : fullText.substring(0, text.length + 1)

        typewriter.value = text

        if (isDeleting) {
            typingSpeed = 30
        }

        if (!isDeleting && text === fullText) {
            typingSpeed = wait
            isDeleting = true
        } else if (isDeleting && text === '') {
            typingSpeed = 100
            isDeleting = false
            wordIndex++
        }

        window.setTimeout(() => initTypewriter(), typingSpeed)
    }

    onMounted(() => initTypewriter())

    return { typewriter }
}