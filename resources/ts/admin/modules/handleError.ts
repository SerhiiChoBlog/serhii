import showToast from '@shared/modules/showToast'

export default (err: any) => {
    showToast({
        text: err.response.data.message || err.response.data.exception || 'Unknown error',
        success: false,
    })
}
