import hljs from 'highlight.js'

export default () => {
    window.setTimeout(() => {
        const blocks = document.querySelectorAll('pre code')

        // Ignoring because types are lying that highlightElement doesn't exist
        // @ts-ignore
        blocks.forEach((block: Element) => hljs.highlightElement(block as HTMLElement))
    }, 0)
}