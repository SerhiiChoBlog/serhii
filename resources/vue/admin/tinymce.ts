// @vue-ignore
const tinymceEditor = window.tinymce

export function getEditorContent(): string {
    return tinymceEditor.activeEditor.getContent()
}

export default tinymceEditor
