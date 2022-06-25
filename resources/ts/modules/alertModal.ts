import sweetAlert, { SweetAlertOptions } from 'sweetalert2'

export default async <T = any>(title: string, html: string, options: SweetAlertOptions<T>) => {
    const response = await sweetAlert.fire<T>({
        title: title,
        html: html,
        showCancelButton: false,
        showConfirmButton: true,
        ...options,
    })
}
