import hljs from 'highlight.js'

export default () => {
    window.setTimeout(() => {
        const blocks = document.querySelectorAll('pre code')
        blocks.forEach((block: Element) => hljs.highlightBlock(block as HTMLElement))
    }, 0)
}