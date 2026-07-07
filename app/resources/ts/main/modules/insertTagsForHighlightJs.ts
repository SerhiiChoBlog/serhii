export default () => {
    const codeElems = document.querySelectorAll('code')

    codeElems.forEach(block => {
        const prevElem = block.parentElement!
        const classes: string = prevElem.getAttribute('class')!

        if (/^language-/.test(classes)) {
            const lang = classes.replace('language-', '').trim()
            const html = `<div class="absolute text-[#b9bec2] block right-2.5 top-1.5 text-xs" aria-hidden="true">${lang}</div>`

            prevElem.insertAdjacentHTML('beforeend', html)
        }
    })
}
