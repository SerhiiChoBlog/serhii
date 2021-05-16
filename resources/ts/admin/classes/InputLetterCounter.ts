export default class {
    public constructor(private fields: HTMLInputElement[]) {}

    public listenForEvents(): void {
        this.fields.forEach(field => {
            this.displayCurrentLetterLeft(field)
            field.addEventListener('keyup', () => this.displayCurrentLetterLeft(field))
        })
    }

    private displayCurrentLetterLeft(field: HTMLInputElement): void {
        const lettersCount = field.value.length
        const maxLength = field.maxLength
        const target = field.parentElement!.querySelector<Element>('.counter')!

        target.innerHTML = `${maxLength - lettersCount}`
    }
}
