import dispatchEvent from './dispatchEvent'
import appConfig from '../appConfig'

export function getEditorContent(): string {
    return tinymce.activeEditor.getContent()
}

export function init(): void {
    tinymce.init({
        // paste_as_text: true,
        // skin: "oxide-dark",
        // content_css: "dark",
        selector: '#content',
        plugins: 'codesample fullscreen code image link table lists paste',
        height: '800px',
        toolbar: 'undo redo | styleselect | bold italic | link image table | alignleft aligncenter alignright | numlist bullist | bullist numlist outdent indent | codesample code | fullscreen',
        image_caption: true,
        codesample_languages: [
            {text: 'C#', value: 'csharp'},
            {text: 'Json', value: 'json'},
            {text: 'Nginx', value: 'nginx'},
            {text: 'SQL', value: 'sql'},
            {text: 'TypeScript', value: 'typescript'},
            {text: 'Apache', value: 'apache'},
            {text: 'C++', value: 'cpp'},
            {text: 'Go', value: 'go'},
            {text: 'Bash', value: 'bash'},
            {text: 'Java', value: 'java'},
            {text: 'Text', value: 'text'},
            {text: 'Ruby', value: 'ruby'},
            {text: 'CSS', value: 'css'},
            {text: 'HTML/XML', value: 'html'},
            {text: 'JavaScript', value: 'javascript'},
            {text: 'Makefile', value: 'makefile'},
            {text: 'PHP', value: 'php'},
            {text: 'Python', value: 'python'},
            {text: 'Yaml', value: 'yaml'},
            {text: 'C', value: 'c'},
            {text: 'Markdown', value: 'markdown'},
            {text: 'PHP Template', value: 'php-template'},
            {text: 'Scss', value: 'scss'},
        ],

        setup: (editor) => {
            editor.on('blur', function () {
                dispatchEvent(appConfig.events.savePost)
            })

            editor.on('keydown', function (e) {
                if ((e.ctrlKey || e.metaKey) && e.code === 'KeyS') {
                    e.preventDefault()
                    dispatchEvent(appConfig.events.savePost)
                }
            })
        }
    })
}
