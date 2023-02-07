import showToast from '@shared/modules/showToast'

export default (err: any): void => {
    console.error(err)

    showToast({
        text: err.response.data.message || 'Server error',
        success: false,
    })
}
