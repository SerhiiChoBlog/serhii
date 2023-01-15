export default <T>(name: string, params?: T, timeout?: number) => {
    const event = new CustomEvent(name, { detail: params })

    if (timeout && timeout > 0) {
        setTimeout(() => window.dispatchEvent(event), timeout)
        return
    }

    window.dispatchEvent(event)
}