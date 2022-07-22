import { getEditorContent } from '../tinymce'
import axios from 'axios'
import EditPostFormElements from '../interfaces/EditPostFormElements'
import SweetAlert from 'sweetalert2'

export default class {
    public constructor(
        private form: HTMLFormElement,
        private postId: number,
    ) { }

    public listenForSubmitEvent(): void {
        setTimeout(() => {
            SweetAlert.fire('Info', 'Choose tags before saving the post', 'info')
        }, 2000)

        this.form.addEventListener('submit', e => {
            e.preventDefault()
            this.handleEvent()
        })

        window.addEventListener('savePost', () => this.handleEvent())
    }

    public handleEvent(): void {
        const formElements = this.form.elements as EditPostFormElements
        const formData = new FormData()
        const tagsElems = formElements['tags[]'] as HTMLInputElement[] | HTMLInputElement

        if (!tagsElems) {
            SweetAlert.fire('Info', 'Choose tags before saving the post', 'info')
            return
        }

        this.showLoading(true)

        const tags = tagsElems instanceof HTMLInputElement
            ? [tagsElems]
            : Array.from(tagsElems)

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
        axios.post<string>(`/admin/posts/${this.postId}`, formData, {
            headers: { 'content-type': 'multipart/form-data' },
        })
            .then(res => this.updatePreviewLink(res.data))
            .catch(err => {
                console.error(err)
                SweetAlert.fire('Error', err, 'error')
            })
            .finally(() => this.showLoading(false))
    }

    private showLoading(show: boolean): void {
        const btn = this.form.querySelector<HTMLButtonElement>('button[type=submit]')!
        const elem = btn.querySelector<HTMLButtonElement>('svg')!

        if (show) {
            elem.classList.add('!inline')
            btn.classList.add('!bg-orange-400')
            return
        }

        elem.classList.remove('!inline')
        btn.classList.remove('!bg-orange-400')
    }

    private updatePreviewLink(newHref: string): void {
        const btn = document.getElementById('preview-the-post') as HTMLAnchorElement

        if (!btn)
            return

        btn.href = newHref
    }
}
