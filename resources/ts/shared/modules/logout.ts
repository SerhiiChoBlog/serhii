import axios from 'axios'
import showToast from '@shared/modules/showToast'
import sweetAlert from 'sweetalert2'

export default async (): Promise<void> => {
    const response = await sweetAlert.fire({
        title: 'Sign out?',
        html: 'Are you sure you want to sign out from your account?',
        showDenyButton: true,
        confirmButtonText: 'Yes, sign out',
        denyButtonText: 'No',
    })

    const wantsToStay = response.isDismissed || response.isDenied

    if (wantsToStay || !Auth)
        return

    try {
        await axios.post('/logout', {
            email: Auth.email,
        })
    } catch (err) {
        console.error(err)
    }

    showToast({ text: `You've been logged out` })

    window.location.reload()
}
