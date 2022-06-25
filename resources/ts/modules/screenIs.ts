export default (screen: 'sm' | 'md' | 'lg' | 'xl' | '2xl'): boolean => {
    switch (screen) {
        case 'sm':
            return window.innerWidth <= 640
        case 'md':
            return window.innerWidth <= 768
        case 'lg':
            return window.innerWidth <= 1024
        case 'xl':
            return window.innerWidth <= 1280
        default:
            return window.innerWidth <= 1536
    }
}
