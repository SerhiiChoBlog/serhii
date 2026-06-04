type Size = 'sm' | 'md' | 'lg' | 'xl' | '2xl'

export default (screen: Size | Size[]): boolean => {
    if (Array.isArray(screen)) {
        console.log('inside if')
        return screen.some(size => screenSize(size))
    }

    console.log('outside if')
    return screenSize(screen)
}

function screenSize(screen: Size): boolean {
    switch (screen) {
        case 'sm':
            console.log('sm')
            return window.innerWidth <= 640
        case 'md':
            console.log('md')
            return window.innerWidth <= 768
        case 'lg':
            console.log('lg')
            return window.innerWidth <= 1024
        case 'xl':
            console.log('xl')
            return window.innerWidth <= 1280
        default:
            console.log('default')
            return window.innerWidth <= 1536
    }
}
