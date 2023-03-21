import { storage } from '@shared/appConfig'
import showToast from '@shared/modules/showToast'

export default class {
    public static refresh(toastMessage?: string): void {
        const scrollPosition = window.scrollY.toString()
        localStorage.setItem(storage.scrollPosition, scrollPosition)

        if (toastMessage) {
            localStorage.setItem(storage.toastMessageAfterRefresh, toastMessage)
        }

        window.location.reload()
    }

    public static scrollToTheLastPosition(): void {
        const scrollPosition = localStorage.getItem(storage.scrollPosition)

        if (!scrollPosition) {
            return
        }

        window.scrollTo(0, parseInt(scrollPosition))
        localStorage.removeItem(storage.scrollPosition)

        const toastMessage = localStorage.getItem(storage.toastMessageAfterRefresh)

        if (!toastMessage) {
            return
        }

        localStorage.removeItem(storage.toastMessageAfterRefresh)

        showToast({ text: toastMessage })
    }
}
