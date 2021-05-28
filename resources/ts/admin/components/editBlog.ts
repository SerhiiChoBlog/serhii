import TagsInput from '../classes/TagsInput';
import InputLetterCounter from '../classes/InputLetterCounter'
import PostImageLoader from '../classes/PostImageLoader'
import PostAutoSave from '../classes/PostAutoSave'

(function ExecuteTagsInputScript() {
    const tagsField = document.getElementById('post-tags') as HTMLInputElement
    const target = document.getElementById('suggestions-target') as Element
    const popup = document.getElementById('post-tags-popup') as Element
    const oldTagsField = document.getElementById('old-post-tags') as HTMLInputElement

    if (!tagsField || !target || !popup || !oldTagsField)
        return

    new TagsInput(tagsField, target, popup, oldTagsField).listenForEvent()
})()

;(function ExecuteLetterCounter() {
    const fields = document.querySelectorAll<HTMLInputElement>('.letter-counter')

    if (!fields)
        return

    new InputLetterCounter(Array.from(fields)).listenForEvents()
})()

;(function ExecutePostImageLoader() {
    const imgElement = document.getElementById('post-image') as HTMLImageElement
    const imgInput = document.getElementById('post-image-input') as HTMLInputElement

    if (!imgElement || !imgInput)
        return

    new PostImageLoader(imgElement, imgInput).listenForEvents()
})()

;(function AutoSaveBlogPost() {
    const form = document.getElementById('edit-post-form') as HTMLFormElement
    const postIdField = document.getElementById('post-id-field') as HTMLInputElement

    if (!form || !postIdField)
        return

    const postId = parseInt(postIdField.value)

    new PostAutoSave(form, postId).listenForSubmitEvent()
})()

