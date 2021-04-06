export default (imageName: string) => {
    const images = require.context('../assets/images/tools/', false, /\.png$/)
    return images(`./${imageName}.png`)
}