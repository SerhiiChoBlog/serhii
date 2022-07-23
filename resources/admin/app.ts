import smoothLoader from 'smooth-loader'
import './components/editBlog'
import Tabs from './modules/Tabs'

smoothLoader('[data-src]');

(function HandleTabs() {
    const tabs = document.querySelectorAll<HTMLAnchorElement>('._tab')

    if (!tabs)
        return

    new Tabs(tabs).handle()
})();

(function HandleLogoutButton() {
    const selector = '._logout-button'
    const btn = document.querySelector<HTMLAnchorElement>(selector)

    if (!btn) {
        console.error(`Element with selector ${selector} not found`)
        return
    }

    function submitForm(e: MouseEvent): void {
        e.preventDefault()

        const selector = '#logout-form'
        const form = document.querySelector<HTMLFormElement>(selector)

        if (!form) {
            console.error(`Form with selector can't be submitted because selector ${selector} not found`)
            return
        }

        if (confirm('Are you sure you want to sign out?')) {
            form.submit()
        }
    }

    btn.addEventListener('click', submitForm)
})()
