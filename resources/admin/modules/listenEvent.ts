export default (name: string, callback: (data: any) => void) => {
    window.addEventListener(name, (e: any) => callback(e.detail))
}
