import SearchTagResponseItem from '../interfaces/SearchTagResponseItem'

export default class {
    private tags: SearchTagResponseItem[]
    private chosenTags: SearchTagResponseItem[]

    public constructor(
        private tagsField: HTMLInputElement,
        private target: Element,
        private popup: Element,
        private oldTagsField: HTMLInputElement,
    ) {
        this.tags = []
        this.chosenTags = []
    }

    public listenForEvent(): void {
        this.tagsField.addEventListener('keyup', () => this.handleEvent(this.tagsField.value))
        this.listenForEnterEventToChooseFirstItemInPopup()
        this.checkIfThereAreOldTags()
    }

    private openPopup(open: boolean | null = true): void {
        open
            ? this.popup.classList.remove('is-hidden')
            : this.popup.classList.add('is-hidden')
    }

    private handleEvent(value: string): void {
        if (value === '') {
            this.openPopup(false)
            return
        }

        fetch(`/api/tags/search/${value}`, { method: 'POST' })
            .then(res => res.json())
            .then((res: SearchTagResponseItem[]) => {
                this.tags = res
                this.printPopupItems()
                this.addEventsPopupItems()
            })
            .catch(err => console.error(err))
    }

    private printPopupItems(): void {
        this.openPopup()

        let popupHtml = ''

        this.tags.forEach(tag => popupHtml += `<li class="_popup-item">${tag.name}</li>`)

        this.popup.innerHTML = popupHtml
    }

    private getHtmlForTag(tag: SearchTagResponseItem): string {
        return `
            <span class="tag is-normal is-dark mr-1" style="background-color: ${tag.color}">
                ${tag.name}
                <button type="button" class="delete is-small" id="delete-tag-${tag.id}"></button>
                <input type="hidden" name="tags[]" value="${tag.id}">
            </span>
        `
    }

    private addEventsPopupItems(): void {
        const popupItems = document.querySelectorAll('._popup-item')!
        popupItems.forEach(item => {
            item.addEventListener('click', () => this.handlePopupItemClickEvent(item.innerHTML.trim()))
        })
    }

    private handlePopupItemClickEvent(tagName: string): void {
        this.tagsField.value = ''
        this.openPopup(false)

        this.addTagToHtml(tagName)
    }

    private addTagToHtml(tagOrName: string | SearchTagResponseItem): void {
        const tag = (typeof tagOrName === 'string')
            ? this.tags.filter(tag => tag.name === tagOrName)[0]
            : tagOrName

        let duplicates = this.chosenTags.filter(chosenTag => chosenTag.id === tag.id)

        if (duplicates.length > 0)
            return

        this.chosenTags.push(tag)

        this.target.insertAdjacentHTML('beforeend', this.getHtmlForTag(tag))

        this.addRemoveTagEvent(tag.id)
    }

    private listenForEnterEventToChooseFirstItemInPopup(): void {
        this.tagsField.addEventListener('keypress', (e: KeyboardEvent) => {
            if (e.code === 'Enter') {
                const tag = this.tags[0] || null

                if (tag) {
                    this.openPopup(false)
                    this.tagsField.value = ''
                    this.addTagToHtml(tag)
                }

                e.preventDefault()
            }
        })
    }

    private checkIfThereAreOldTags(): void {
        const oldTags = JSON.parse(this.oldTagsField.value) as SearchTagResponseItem[]
        this.tags = oldTags

        oldTags.forEach(oldTag => this.addTagToHtml(oldTag))
    }

    private addRemoveTagEvent(id: number): void {
        const deleteTagButton = document.getElementById(`delete-tag-${id}`)!

        deleteTagButton.addEventListener('click', () => {
            deleteTagButton.parentElement!.remove()
            this.chosenTags = this.chosenTags.filter(chosenTag => chosenTag.id !== id)
        })
    }
}
