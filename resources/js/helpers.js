import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.min.css';
import './assets/css/toast.css';

export function showToast(icon = "error", message = "Ocurrió un error, por favor vuelva a intentar") {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
    })
    Toast.fire({
        icon: icon,
        title: message,
        customClass: {
            popup: 'swa-bg',
            title: 'swa-bg',
            content: 'swa-bg',
        }
    })
}
