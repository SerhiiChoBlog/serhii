import { getEditorContent } from '../tinymce'
import axios from 'axios'
import EditPostFormElements from '../interfaces/EditPostFormElements'

export default class {
    public constructor(
        private form: HTMLFormElement,
        private postId: number,
    ) {}

    public listenForSubmitEvent(): void {
        this.form.addEventListener('submit', e => {
            e.preventDefault()
            this.showLoading(true)
            this.handleEvent()
        })

        window.addEventListener('postEditorBlurEvent', () => {
            this.showLoading(true)
            this.handleEvent()
        })
    }

    private handleEvent(): void {
        const formElements = this.form.elements as EditPostFormElements
        const formData = new FormData()

        const tags = Array.from(formElements['tags[]'])
        const imageFile = formElements.image.files![0] as File

        formData.append('title', formElements.title.value)
        formData.append('intro', formElements.intro.value)
        formData.append('content', getEditorContent())
        formData.append('image', imageFile)
        formData.append('tags', JSON.stringify(tags.map(tag => tag.value)))
        formData.append('is-published', formElements['is-published'].checked ? 'on' : 'off')
        formData.append('_method', 'put')

        this.sendData(formData)
    }

    private sendData(formData: FormData): void {
        axios.post(`/admin/posts/${this.postId}`, formData, {
            headers: { 'content-type': 'multipart/form-data' },
        })
            .catch(err => {
                console.error(err)
                alert(err)
            })
            .finally(() => this.showLoading(false))
    }

    private showLoading(show: boolean): void {
        const btn = this.form.querySelector<HTMLButtonElement>('button[type=submit]')!
        show ? btn.classList.add('is-loading') : btn.classList.remove('is-loading')
    }
}
