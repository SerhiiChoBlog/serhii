export default () => {
    function toggleMobileNavbar() {
        const burger = document.getElementById('burger-button')!
        const navMenu = document.getElementById('nav-menu')!

        if (burger.classList.contains('is-active')) {
            burger.classList.remove('is-active')
            navMenu.classList.remove('is-active')
        } else {
            burger.classList.add('is-active')
            navMenu.classList.add('is-active')
        }
    }

    return { toggleMobileNavbar }
}