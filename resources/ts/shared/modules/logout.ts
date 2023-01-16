import axios from 'axios'
import showToast from '@admin/modules/showToast'

export default (): void => {
    if (!confirm('Are you sure you want to logout?'))
        return

    axios.post('/logout')
        .then(resp => {
            showToast({ text: `You've been logged out` })
            window.location.href = '/login'
        })
        .catch(err => console.error(err))
}
