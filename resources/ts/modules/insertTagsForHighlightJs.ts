export default () => {
    const codeElems = document.querySelectorAll('code.hljs')

    codeElems.forEach(block => {
        const preElem = block.parentElement!
        const classes: string = preElem.getAttribute('class')!

        if (/^language-/.test(classes)) {
            const lang = classes.replace('language-', '').trim()
            preElem.insertAdjacentHTML('beforeend', `<div class="code-language-tag">${lang}</div>`)
        }
    })
}
