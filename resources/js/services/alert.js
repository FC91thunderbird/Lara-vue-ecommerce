import Swal from 'sweetalert2'

export default function useAlert() {

    function topAlert(icon, title, position = 'top-end') {
        const Toast = Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: icon,
            title: title
        })
    }

    function centerAlert(icon, position = 'center') {
        return new Promise((resolve) => {
            Swal.fire({
                position: position,
                icon: icon,
                title: 'Are you sure?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                resolve(result);
            });
        });
        // Swal.fire({
        //     position: position,
        //     icon: icon,
        //     // title: title,
        //     // showConfirmButton: false,
        //     // timer: 1500,

        // title: 'Are you sure?',
        // showCancelButton: true,
        // confirmButtonColor: '#3085d6',
        // cancelButtonColor: '#d33',
        // confirmButtonText: 'Yes, delete it!'
        // })
    }

    async function centerDialogAlert(icon, text = 'Something went wrong!', title = 'Oops...', ) {
        return await Swal.fire({
            icon: icon,
            title: 'Oops...',
            text: text,
            confirmButtonText: 'Ok',
        })
    }
    
    return { topAlert, centerAlert, centerDialogAlert };
}