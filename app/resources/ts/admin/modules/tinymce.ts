import type { EditorOptions } from 'tinymce'

// @ts-ignore
export const tinymceConfig: EditorOptions = {
    paste_as_text: true,
    // content_css: "dark",
    // skin: "oxide-dark",
    selector: '#content',
    plugins: ['codesample', 'fullscreen', 'code', 'image', 'link', 'table', 'lists'], // todo: paste plugin not available
    height: 600,
    toolbar: [
        { name: '', items: ['undo', 'redo'] },
        {
            name: '',
            items: ['styles', 'bold', 'italic', 'forecolor', 'removeformat'],
        },
        { name: '', items: ['link', 'image'] },
        { name: '', items: ['alignleft', 'aligncenter', 'alignright'] },
        { name: '', items: ['numlist', 'bullist'] },
        { name: '', items: ['codesample', 'code', 'fullscreen'] },
    ],
    image_caption: true,
    codesample_languages: [
        { text: 'Bash', value: 'bash' },
        { text: 'CSS', value: 'css' },
        { text: 'Dockerfile', value: 'dockerfile' },
        { text: 'Go', value: 'go' },
        { text: 'Json', value: 'json' },
        { text: 'Lua', value: 'lua' },
        { text: 'PHP', value: 'php' },
        { text: 'Text', value: 'plaintext' },
        { text: 'Python', value: 'python' },
        { text: 'SQL', value: 'sql' },
        { text: 'JavaScript', value: 'javascript' },
        { text: 'TypeScript', value: 'typescript' },
        { text: 'Yaml', value: 'yaml' },
        { text: 'XML', value: 'xml' },
        { text: 'HTML', value: 'html' },
        { text: 'Diff', value: 'diff' },
    ],
}
