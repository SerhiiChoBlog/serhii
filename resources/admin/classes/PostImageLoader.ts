export default class {
    public constructor(private imgElement: HTMLImageElement, private imgInput: HTMLInputElement) {}

    public listenForEvents(): void {
        const fileReader = new FileReader()
        const src = this.imgInput
        const target = this.imgElement

        this.imgInput.addEventListener('change', () => {
            if (src.files && src.files.length !== 0) {
                fileReader.readAsDataURL(src.files[0])
                fileReader.onload = function () {
                    target.src = this.result as string
                }
            } else {
                target.src = '/storage/posts/placeholder.jpg'
            }
        })
    }
}
