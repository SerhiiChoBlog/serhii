import showToast from './showToast'

export default (err: any) => {
    showToast({
        text: err.response.data.message,
        success: false,
    })
}
