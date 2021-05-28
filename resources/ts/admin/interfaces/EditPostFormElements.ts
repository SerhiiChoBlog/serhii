export default interface EditPostFormElements extends HTMLFormControlsCollection {
    title: HTMLInputElement
    intro: HTMLInputElement
    image: HTMLInputElement
    'tags[]': HTMLInputElement[]
    'is-published': HTMLInputElement
    'published-at': HTMLInputElement
}
