import showToast from './showToast'

export default (err: any) => {
    showToast({
        text: err.response.data.message || err.response.data.exception || 'Uknown error',
        success: false,
    })
}
