export function getToolsImages(imageName: string) {
    const images = require.context('../assets/images/tools', false, /\.png$/)
    return images(`./${imageName}.png`)
}

export function getLanguagesImages(imageName: string) {
    const images = require.context('../assets/images/languages', false, /\.png$/)
    return images(`./${imageName}.png`)
}